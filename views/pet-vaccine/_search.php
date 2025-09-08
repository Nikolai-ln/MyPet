<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PetVaccineSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pet-vaccine-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pet_vaccine_id') ?>

    <?= $form->field($model, 'pet_id') ?>

    <?= $form->field($model, 'vaccine_id') ?>

    <?= $form->field($model, 'date_given') ?>

    <?= $form->field($model, 'notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
