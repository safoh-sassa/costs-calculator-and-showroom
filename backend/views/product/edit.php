<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;

$this->title = 'Edit Product';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-edit-product">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>


            <?= $form->field($model, 'model')->textInput(['value' => $product->product_name]) ?>
            <?= $form->field($model, 'type_id')
                ->label('Type')
                ->dropDownList(
                    Product::getTypeSelectArray(),
                    ['options' => [$product->type_id =>['Selected' => true]]]) ?>

            <?= $form->field($model, 'outer_yarn_percent')->textInput(['value' => $product->outer_yarn_percent]) ?>

            <?= $form->field($model, 'outer_yarn_id')
                ->label('Outer Yarn')
                ->dropDownList(
                    Product::getYarnSelectArray(),
                    [
                        'prompt' => '',
                        'options' => [$product->outer_yarn_id =>['Selected' => true]]
                    ]) ?>

            <?= $form->field($model, 'inner_yarn_percent')->textInput(['value' => $product->inner_yarn_percent == 0 ? '' : $product->inner_yarn_percent]) ?>

            <?= $form->field($model, 'inner_yarn_id')
                ->label('Inner Yarn')
                ->dropDownList(
                    Product::getYarnSelectArray(),
                    [
                        'prompt' => '',
                        'options' => [$product->inner_yarn_id =>['Selected' => true]]
                    ]) ?>

            <?= $form->field($model, 'weight_id')
                ->label('Weight')
                ->dropDownList(
                    Product::getWeightSelectArray(),
                    [
                        'prompt' => '',
                        'options' => [$product->weight_id =>['Selected' => true]]
                    ]) ?>

            <?php if( $product->picture ):?>
                <br>
                <p>Current picture:</p>
                <div class="current-picture clearfix">
                    <?= Html::img(Product::getPicturePath($product->id), [
                        'alt' => $product->product_name,
                        'style' => 'max-width: 150px; height: auto;'
                    ]) ?>
                </div>
                <br>
            <?php endif; ?>
            <?= $form->field($model, 'picture')->label($product->picture ? 'Choose a new one' : 'Picture')->fileInput() ?>


            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
