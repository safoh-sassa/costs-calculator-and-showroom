var commission = 0;
var price = 0;

jQuery(function ($) {
    $(document).ready(function () {
        if( $('#product-form-price-list').length ) {
            var productSelectInput = $('#pricelistaddform-product_id');
                 
            // On the change of select, it will load the price
            productSelectInput.on('input', function () {
                var currentProductId = parseInt( $.trim($(this).val()) );
                if($('#pricelistaddform-product_id').val() != 0){
                $('#add-product').show(); 
                } else{            
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
                            console.log(data.price);
                        }
                    },
                    error: function (errorCode) {
                        console.log('Error to work autoload.');
                    },
                    timeout: 15000
                });
            });

            $('#add-product').on('click', function(event)  {

                event.preventDefault();
                $('#current-product-price').hide();
                $('img').hide();
                $(this).hide();
                var productIdOnClick = parseInt( $.trim( productSelectInput.val()));
                               
                clearAlert();

                        var json = {};

                      
                            $('#pricelistaddform-product_id').find('option[value="'+ productIdOnClick +'"]').remove();
                            $('#pricelistaddform-quantity').val(1);

                            json = {
                                "id": productIdOnClick,
                                "price": price,
                                "commission":commission
                            };

                            insertNewProduct2Json(json);

                return false;
            });
        }
    });
   
});


if( $('#product-form-price-list').length ) {
    function getJsonFromTextarea() {
        var textareaText = $.trim( $('#pricelistaddform-products_json').val() );

        if( textareaText != '' ) {
            return JSON.parse(textareaText);
        } else {
            // console.log('Textarea is empty..');
            return false;
        }
    }

    function insertNewProduct2Json(object, textarea) {
        var products = getJsonFromTextarea();
        var textarea = $('#pricelistaddform-products_json');
        var json = {};

        if( !$.isEmptyObject(products) ) {
            var productKeys = Object.keys(products);
            var nextProductKey = parseInt(productKeys.slice(-1).pop()) + 1;

            var products = getJsonFromTextarea();

            $.each(products, function (key, _product) {
                json[key] = {
                    "id": _product.id,
                    "price": _product.price,
                    "commission": _product.commission
                };
            });

            json[nextProductKey] = {
                "id": object.id,
                "price": object.price,
                "commission": object.commission
            };
        } else {
            json[1] =  {
                "id": object.id,
                "price": object.price,
                "commission": object.commission
            };
        }

        alert('success', 'Product was added.');
        textarea.val(JSON.stringify(json));
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


