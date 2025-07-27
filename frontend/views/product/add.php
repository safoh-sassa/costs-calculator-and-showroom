<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;

$this->title = 'Add Product';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-product">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
            ]); ?>


            <?= $form->field($model, 'model')->textInput() ?>
            <?= $form->field($model, 'type_id')
                ->label('Type')
                ->dropDownList(Product::getTypeSelectArray()) ?>

            <?= $form->field($model, 'outer_yarn_percent')->textInput() ?>

            <?= $form->field($model, 'outer_yarn_id')
                ->label('Outer Yarn')
                ->dropDownList(Product::getYarnSelectArray(), ['prompt' => '']) ?>

            <?= $form->field($model, 'inner_yarn_percent')->textInput() ?>

            <?= $form->field($model, 'inner_yarn_id')
                ->label('Inner Yarn')
                ->dropDownList(Product::getYarnSelectArray(), ['prompt' => '']) ?>

            <?= $form->field($model, 'weight_id')
                ->label('Weight')
                ->dropDownList(Product::getWeightSelectArray(), ['prompt' => '']) ?>

            <?= $form->field($model, 'picture')->fileInput() ?>



            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
