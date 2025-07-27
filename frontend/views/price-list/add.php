<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;
use common\models\Customer;

$this->title = 'Add Price List';
$this->params['breadcrumbs'][] = $this->title;

$p = new Product();

?>
<div class="site-add-product">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-7">
            <?php $form = ActiveForm::begin(['id' => 'product-form-price-list']); ?>


            <?= $form->field($model, 'customer_id')
                ->label('Customer')
                ->dropDownList(Customer::getCustomerSelectArray()) ?>


            <div class="row">
                <div class="col-lg-12">

                    <?= $form->field($model, 'product_id')
                        ->label('Product')
                        ->dropDownList($p->getProductSelectArray()) ?>

                    <?= $form->field($model, 'products_json')->label(false)->textArea(['style' => 'display: none; z-index: -9999;']) ?>
                </div>
            </div>

            <?= Html::a('Add product', '#', ['id' => 'add-product', 'class' => 'btn btn-s btn-success']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'signup-button', 'id' => 'save-btn']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
