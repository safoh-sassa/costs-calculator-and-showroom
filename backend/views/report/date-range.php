<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;
use common\models\Date;
use common\models\App;
use common\models\Product;
use common\models\InvoiceItem;

$this->title = 'Customers Sales';
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= Html::encode($this->title) ?></h2>

<div class="row clearfix">
    <div class="col-xs-2">
        <div class="row">
            <div class="col-xs-12">
                <label>Date from</label>
                <input class="form-control" type="date" name="date-from" id="date-from" value="" placeholder="Date from">
            </div>
            <div class="col-xs-12">
                <label>Time from</label>
                <input class="form-control" type="time" name="time-from" id="time-from" value="" placeholder="Time from">
            </div>
        </div>
       
        
    </div>
    <div class="col-xs-2">
        <div class="row">
            <div class="col-xs-12">
                <label>Date to</label>
                <input class="form-control" type="date" name="date-to" id="date-to" value="" placeholder="Date to">
            </div>
            <div class="col-xs-12">
                <label>Time to</label>
                <input class="form-control" type="time" name="time-to" id="time-to" value="" placeholder="Time to">
            </div>
        </div>
    </div>
    <div class="col-lg-12" >
         <div class="row">
            <div class="col-xs-4">
                <label>Value</label>
                <input class="form-control" type="number" name="value" id="value" value=" placeholder="Value ($)">
            </div>
            <div class="col-xs-12">
                <br><?= Html::a('Show', '#', ['onclick' => 'setLink($(this))', 'class' => 'btn btn-md btn-success', 'style' => 'margin-top: 5px;']) ?>
            </div>
        </div>
    </div>
</div>
<br><br>

<script> 
    function setLink(thiz) {
        var dateFrom = $.trim( $('#date-from').val());
        var dateTo = $.trim( $('#date-to').val());
        var timeFrom = $.trim( $('#time-from').val());
        var timeTo = $.trim( $('#time-to').val());
        var value = $.trim( $('#value').val());

        if( dateFrom == '' || typeof dateFrom == 'undefined') {
            alert('Please fill in date from.');
            return;
        }

        if( dateTo == '' || typeof dateFrom == 'undefined' ) {
            alert('Please fill in date to.');
            return; 
        }

        if( value == '') {
            alert('Please fill in the value');
            return;
        }
       
        thiz.attr('href', 'index.php?r=report/date-range&datefrom=' + dateFrom + '&dateto=' + dateTo  + '&timefrom=' + timeFrom  + '&timeto=' + timeTo + '&value=' + value);
        
    }
</script>

<?php if( App::get('datefrom') && App::get('dateto') ): ?>

<h2>Search results</h2>
<p>Customers sales from <?= Html::encode(Date::format('dmy', strtotime(App::get('datefrom')))) ?> to <?= Html::encode(Date::format('dmy', strtotime(App::get('dateto')))) ?> and equal $ <?= Html::encode(App::get('value')) ?> or more.</p>

<table class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>Customer name</th>
            <th>Country</th>
            <th>City</th>
            <th>Address</th>
            <th>Total ($)</th>
        </tr>
    </thead>
    <tbody>
        <?php if( $customers): ?>
            <?php foreach($customers as $customer): ?>
                <?php $c = InvoiceItem::getCustomerByHeaderId($customer['invoice_header_id']) ?>
                <tr>
                    <td><?= Html::encode($c->customer_name) ?></td>
                    <td><?= Html::encode($c->country) ?></td>
                    <td><?= Html::encode($c->city) ?></td>
                    <td><?= Html::encode($c->address) ?></td>
                    <td><?= Html::encode($customer['total']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">
                    <p class="text-center">No customers found for this date range.</p>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php endif; ?>



