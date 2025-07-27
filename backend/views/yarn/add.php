<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;

$this->title = 'Add Yarn';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-yarn">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>


            <?= $form->field($model, 'yarn_name')->textInput() ?>
           

            <?= $form->field($model, 'cost')->textInput() ?>

            <?= $form->field($model, 'description')->textInput() ?>
          
            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'yarn-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
