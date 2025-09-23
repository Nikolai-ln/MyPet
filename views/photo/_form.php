<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Pet;

/** @var yii\web\View $this */
/** @var app\models\Photo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="photo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'files[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

    <!-- <?= Html::activeHiddenInput($model, 'pet_id') ?> -->

    <?= $form->field($model, 'pet_id', ['options' => ['class' => 'form-group']])->dropDownList(
        ArrayHelper::map(Pet::find()->all(), 'pet_id', 'name'),
        ['prompt' => 'Select Pet']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
