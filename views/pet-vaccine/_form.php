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
            ['prompt' => 'Select Vaccine', 'id' => 'vaccine-id']
    ) ?>

    <?= $form->field($model, 'description')->textarea([
        'rows' => 3,
        'id' => 'vaccine-description',
        'value' => $model->vaccine ? $model->vaccine->description : '',
        'readonly' => true
    ]) ?>

    <?php
        $vaccines = Vaccine::find()->all();
        $descriptions = [];
        foreach ($vaccines as $vaccine) {
            $descriptions[$vaccine->vaccine_id] = $vaccine->description;
        }

        $this->registerJs("
            var vaccineDescriptions = " . json_encode($descriptions) . ";

            $('#vaccine-id').on('change', function() {
                var id = $(this).val();
                if (id && vaccineDescriptions[id]) {
                    $('#vaccine-description').val(vaccineDescriptions[id]);
                } else {
                    $('#vaccine-description').val('');
                }
            });
        ");
    ?>

    <?= $form->field($model, 'date_given')->input('date') ?>

    <?= $form->field($model, 'notes')->textarea(['rows' => 3, 'maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
