<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;

$this->title = 'Add Weight';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-weight">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
            ]); ?>


            <?= $form->field($model, 'weight_gram')->textInput() ?>

            <?= $form->field($model, 'type_id')
                ->label('Type')
                ->dropDownList(Product::getTypeSelectArray()) ?>
                
            <?= $form->field($model, 'size')->textInput() ?>
            <?= $form->field($model, 'description')->textArea(['rows' => 5]) ?>
          
            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
