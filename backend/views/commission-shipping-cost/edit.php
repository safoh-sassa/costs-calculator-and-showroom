<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit Commission & Shipping Cost ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-2">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'commission')->textInput(['value' => $csc->commission_value]) ?>
            <p style="margin-bottom: 40px">Commission %/Dozen</p>
                <?= $form->field($model, 'shipping')->textInput(['value' => $csc->shipping_cost]) ?>
            <p>Shipping Cost USD/KG</p>
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
