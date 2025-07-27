<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;

$this->title = 'Add Customer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-edit-yarn">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'customer_name')->textInput(); ?>
            <?= $form->field($model, 'country')->textInput(); ?>
            <?= $form->field($model, 'city')->textInput(); ?>
            <?= $form->field($model, 'address')->textInput(); ?>
            <?= $form->field($model, 'phone')->textInput(); ?>
            <?= $form->field($model, 'email')->textInput(); ?>
          
           


            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'yarn-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
