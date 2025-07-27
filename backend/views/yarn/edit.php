<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Product;

$this->title = 'Edit Yarn';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-edit-yarn">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>


            <?= $form->field($model, 'yarn_name')->textInput(['value' => $yarn->yarn_name]) ?>
           

            <?= $form->field($model, 'cost')->textInput(['value' => $yarn->cost]) ?>

            <?= $form->field($model, 'description')->textInput(['value' => $yarn->description]) ?>
          
            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'yarn-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
