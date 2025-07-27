var commission = 0;
var price = 0;

jQuery(function ($) {
       
    $(document).ready(function () {

            if( $('#product-form').length ) {
            $('#add-product').hide();
            $('.field-invoiceaddform-quantity').hide();
            var productSelectInput = $('#invoiceaddform-product_id');
            
            // On the change of select, it will load the price
            productSelectInput.on('input', function () {
                var currentProductId = parseInt( $.trim($(this).val()) );

                if($('#invoiceaddform-product_id').val() != 0){
                    $('#add-product').show(); 
                    $('#invoiceaddform-quantity').val(1);
                    $('.field-invoiceaddform-quantity').show();
                    $('#invoiceaddform-quantity').focus();
                } else{            
                    $('.field-invoiceaddform-quantity').hide();  
                    $('#add-product').hide(); 
                }

                $('#current-product-price').remove();
                                
                $.ajax({
                    url: '/costs/backend/WEB/index.php?r=invoice/productinfo',
                    type: 'POST',
                    data: {
                        productId: currentProductId
                    },
                    success: function (reply) {
                        var data = JSON.parse(reply);

                        if( data.type == 'success' ) {
                            var html = '';
                            price = data.price;
                            commission = data.commission.toFixed(2);
                            html = '<p id="current-product-price" style="margin-top:10px" ><strong>Price: $'+ data.price +'</strong><br/>';
                            if( data.imgUrl !== '')
                                html += '<img src="'+ data.imgUrl +'" alt="" style="max-width: 150px; max-height: 150px;margin-top:10px" /></p>';
                            else
                                html += '<span>No image for this product.</span></p>';

                            productSelectInput.after(html);
                        } else {
                            console.log('Error to get a product.');
                        }
                    },
                    error: function (errorCode) {
                        console.log('Error to work autoload.');
                    },
                    timeout: 15000
                });
            });
           
            // on add product
            $('#add-product').on('click', function(event)  {
                event.preventDefault();
                $('#current-product-price').hide();
                $('.field-invoiceaddform-quantity').hide();
                $(this).hide();

                var productIdOnClick = parseInt( $.trim( productSelectInput.val()));
                var quantity = parseInt( $.trim( $('#invoiceaddform-quantity').val() ) );
                
                if( quantity <= 0 || isNaN(quantity) || quantity == '') {
                    alert('danger', 'You need to have quantity equal to 1 or greater.');
                    $('#current-product-price').show();
                    $('#invoiceaddform-quantity').val(1);
                    $('.field-invoiceaddform-quantity').show();
                    $('#invoiceaddform-quantity').focus();
                    return false;
                }
                clearAlert();
              
                        var json = {};
                  
                            $('#invoiceaddform-product_id').find('option[value="'+ productIdOnClick +'"]').remove();
                            $('#invoiceaddform-quantity').val(1);

                            json = {
                                "id": productIdOnClick,
                                "price": price,
                                "quantity": !quantity || quantity == '' ? 0 : quantity,
                                "commission":commission
                            };
                            
                            insertNewProduct2Json(json);
              
                return false;
            });
        }
    });
});


if( $('#product-form').length ) {
    function getJsonFromTextarea() {
        var textareaText = $.trim( $('#invoiceaddform-products_json').val() );

        if( textareaText != '' ) {
            return JSON.parse(textareaText);
        } else {
            return false;
        }
    }
    
    function insertNewProduct2Json(object) {
        var textarea = $('#invoiceaddform-products_json');
        var products = getJsonFromTextarea();
        var json = {};
        
        if( !$.isEmptyObject(products) ) {
            var productKeys = Object.keys(products);
            var nextProductKey = parseInt(productKeys.slice(-1).pop()) + 1;
                      
            products[nextProductKey] = {
                "id": object.id,
                "price": object.price,
                "quantity": !object.quantity || object.quantity == '' ? 0 : object.quantity,
                "commission": object.commission
            };
            textarea.val(JSON.stringify(products));
        } else {
            json[1] =  {
                "id": object.id,
                "price": object.price,
                "quantity": !object.quantity || object.quantity == '' ? 0 : object.quantity,
                "commission": object.commission
            };
            textarea.val(JSON.stringify(json));
        }
        alert('success', 'Product was added.');
        
    }

    function alert(type, message) {
            if( type == 'success' ) {
            $('#success-product').fadeOut(200, function() {
                $(this).remove();
            });
            $('#save-btn').after('<p id="success-product" class="alert alert-success">'+ message +'</p>');
            setTimeout(function() {
                $('#success-product').fadeOut(200);
            }, 3000);
        } else {
            $('#error-product').fadeOut(200, function() {
                $(this).remove();
            });
            $('#save-btn').after('<p id="error-product" class="alert alert-danger">'+ message +'</p>');
         }
    }

    function clearAlert() {
        $('#success-product').fadeOut(200, function() {$(this).remove();});
        $('#error-product').fadeOut(200, function() {$(this).remove();});
    }
}

