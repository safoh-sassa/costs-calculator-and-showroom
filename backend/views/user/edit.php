<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\UserGroup;

$this->title = 'Edit Sales Representative';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-product">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-3">
            <?php $form = ActiveForm::begin(); ?>


            <?= $form->field($model, 'group_id')
                ->label('Group')
                ->dropDownList(
                    UserGroup::getGroupSelectArray(),
                    ['options' => [$user->group_id =>['Selected' => true]]]) ?>

            <?= $form->field($model, 'first_name')->textInput(['value' => $user->first_name]) ?>
            <?= $form->field($model, 'last_name')->textInput(['value' => $user->last_name]) ?>
            <?= $form->field($model, 'username')->textInput(['value' => $user->username]) ?>
            <?= $form->field($model, 'email')->textInput(['value' => $user->email]) ?>

            <?= $form->field($model, 'password')->textInput() ?>


            <div class="form-group">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
