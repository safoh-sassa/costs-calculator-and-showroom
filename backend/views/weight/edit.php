<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;

$this->title = 'Edit Weight';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-weight">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'weight_gram')->textInput(['value' => $weight->weight_gram]) ?>

            <?= $form->field($model, 'type_id')
                ->label('Type')
                ->dropDownList(
                    Product::getTypeSelectArray(),
                    ['options' => [$weight->type_id =>['Selected' => true]]]) ?>
                
            <?= $form->field($model, 'size')->textInput(['value' => $weight->size]) ?>
            <?= $form->field($model, 'description')->textArea(['rows' => 5, 'value' => $weight->description]) ?>
           
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'weight-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
