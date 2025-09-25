<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PetVaccine $model */

if ($model->pet_id)
    $this->title = 'Add a Pet Vaccine for ' . $model->pet->name;
else
    $this->title = 'Add a Pet Vaccine';
$this->params['breadcrumbs'][] = ['label' => 'Pet Vaccines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-vaccine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
