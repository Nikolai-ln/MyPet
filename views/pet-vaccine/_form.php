<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PetVaccine $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pet-vaccine-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pet_id')->textInput() ?>

    <?= $form->field($model, 'vaccine_id')->textInput() ?>

    <?= $form->field($model, 'date_given')->textInput() ?>

    <?= $form->field($model, 'notes')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
