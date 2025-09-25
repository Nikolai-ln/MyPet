<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PetVaccine $model */

$this->title = 'Update Pet Vaccine for ' . $model->pet->name; // . $model->pet_vaccine_id;
$this->params['breadcrumbs'][] = ['label' => 'Pet Vaccines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Pet vaccine ' . $model->pet_vaccine_id, 'url' => ['view', 'pet_vaccine_id' => $model->pet_vaccine_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pet-vaccine-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
