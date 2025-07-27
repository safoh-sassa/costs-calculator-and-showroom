<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;
use common\models\Date;
use common\models\App;
use common\models\Product;


$this->title = 'Total Sold Products';
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
        
        thiz.attr('href', 'index.php?r=report/total&datefrom=' + dateFrom + '&dateto=' + dateTo  + '&timefrom=' + timeFrom  + '&timeto=' + timeTo);
    }
</script>

<?php if( App::get('datefrom') && App::get('dateto') ) :?>
    <h2>Search results</h2>
    <p>Total sold product from <?= Html::encode(Date::format('dmy', strtotime(App::get('datefrom')))) ?> to <?= Html::encode(Date::format('dmy', strtotime(App::get('dateto')))) ?>.</p>

    <?php if( $total > 0 ): ?>
        <p class="alert alert-success"><strong>Total of sales is:</strong> $<?= Html::encode($total) ?></p>
    <?php else: ?>
        <p class="alert alert-danger">Sorry, no sales were found for this period.</p>
    <?php endif; ?>
<?php endif; ?> 





