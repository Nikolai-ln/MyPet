<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Vaccine;

/** @var yii\web\View $this */
/** @var app\models\PetVaccine $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pet-vaccine-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->pet_id) {
            $form->field($model, 'pet_id')->hiddenInput([
                'value' => $model->pet_id])->label(false);
        }
        elseif (!Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin') {
            $petsList = ArrayHelper::map(\app\models\Pet::find()->all(), 'pet_id', 'name');
            echo $form->field($model, 'pet_id')->dropDownList($petsList, [
                'prompt' => 'Select Pet'
            ]);
        }
    ?>

    <?= $form->field($model, 'vaccine_id')->dropDownList(
            ArrayHelper::map(Vaccine::find()->all(), 'vaccine_id', 'name'),
            ['prompt' => 'Select Vaccine']
    ) ?>

    <?= $form->field($model, 'date_given')->input('date') ?>

    <?= $form->field($model, 'notes')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
