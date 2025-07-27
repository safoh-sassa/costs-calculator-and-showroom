<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\UserGroup;

$this->title = 'Add Sales Representative';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-product">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>


            <?= $form->field($model, 'group_id')
                ->label('Group')
                ->dropDownList(UserGroup::getGroupSelectArray()) ?>

            <?= $form->field($model, 'first_name')->textInput() ?>
            <?= $form->field($model, 'last_name')->textInput() ?>
            <?= $form->field($model, 'username')->textInput() ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'password')->textInput() ?>


            <div class="form-group">
                <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
