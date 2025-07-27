<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;

$this->title = 'Edit Customer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-edit-yarn">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'customer_name')->textInput(['value' => $customer->customer_name]); ?>
            <?= $form->field($model, 'country')->textInput(['value' => $customer->country]); ?>
            <?= $form->field($model, 'city')->textInput(['value' => $customer->city]); ?>
            <?= $form->field($model, 'address')->textInput(['value' => $customer->address]); ?>
            <?= $form->field($model, 'phone')->textInput(['value' => $customer->phone]); ?>
            <?= $form->field($model, 'email')->textInput(['value' => $customer->email]); ?>
          
           


            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'yarn-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
