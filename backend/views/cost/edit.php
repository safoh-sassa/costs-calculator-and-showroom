<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit '.Html::encode($cost->cost_type) ;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-product">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'cost_amount')->textInput(['value' => $cost->cost_amount]) ?>
            <?= Html::encode($cost->description) ?>
            <div class="form-group" style="margin-top: 20px">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
