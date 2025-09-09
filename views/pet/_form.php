<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\Pet $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pet-form">

    <?php $form = ActiveForm::begin(['options' => ['data-cy' => 'petForm-form']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'data-cy' => 'petForm-inputPet-name']) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'data-cy' => 'petForm-inputPet-type']) ?>

    <?= $form->field($model, 'breed')->textInput(['maxlength' => true, 'data-cy' => 'petForm-inputPet-breed']) ?>

    <?= $form->field($model, 'date_of_birth')->input('date', ['data-cy' => 'petForm-inputPet-dateOfBirth']) ?>

    <?= $form->field($model, 'information')->textInput(['maxlength' => true, 'data-cy' => 'petForm-inputPet-information']) ?>

    <?= $form->field($model, 'owner')->textInput(['maxlength' => true, 'data-cy' => 'petForm-inputPet-owner']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'data-cy' => 'petForm-inputPet-address']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'data-cy' => 'petForm-inputPet-email']) ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'data-cy' => 'petForm-inputPet-phoneNumber']) ?>

    <?php if (Yii::$app->user->identity->role === 'admin'): ?>
        <?= $form->field($model, 'user_id', ['options' => ['data-cy' => 'petForm-inputPet-ownerLabel']])->dropDownList(
            ArrayHelper::map(User::find()->all(), 'user_id', 'username'),
            ['prompt' => 'Select User', 'data-cy' => 'petForm-inputPet-selectUser']
        ) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'data-cy' => 'petForm-inputPet-save-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
