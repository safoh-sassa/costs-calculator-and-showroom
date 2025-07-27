<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Dropdown;
use common\models\Date;
use common\models\App;
use common\models\Product;


$this->title = 'Most Sold Products';
$this->params['breadcrumbs'][] = $this->title;
?>


<h2><?= Html::encode($this->title) ?></h2>

<div class="row clearfix">
    <div class="col-xs-3">
        <label for="number">Select number of products:</label>
        <div class="input-group">
          <input type="number" name="number" id="number" onfocusout="$(this).attr('value', $(this).val()); $('#num-rep').attr('href', '/costs/backend/web/index.php?r=report/most&number=' + $(this).val());" onkeypress="$(this).attr('value', $(this).val()); $('#num-rep').attr('href', '/costs/backend/web/index.php?r=report/most&number=' + $(this).val());" value="<?= App::get('number') != '' ? App::get('number') : '3' ?>" class="form-control">
          <span class="input-group-btn">
            <a id="num-rep" href="/costs/backend/web/index.php?r=report/most&number=3" class="btn btn-success" type="button">Show</a>
          </span>
        </div><!-- /input-group -->
    </div>
</div>
<br><br>


<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-3">
        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>

                <?php 

                if( $products ):
                    foreach($products as $key => $product): ?>
                        <tr>
                            <td><?= Html::encode( Product::getProductName( $product['product_id'] ) ) ?></td>
                            <td><?= Html::encode( $product['total_quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2"><p class="text-center">No products to display.</p></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>





