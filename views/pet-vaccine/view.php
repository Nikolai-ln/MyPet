<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\PetVaccine $model */

$this->title = $model->pet->name;
$this->params['breadcrumbs'][] = ['label' => 'Pet Vaccines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pet-vaccine-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pet_vaccine_id' => $model->pet_vaccine_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'pet_vaccine_id' => $model->pet_vaccine_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'pet_vaccine_id',
            // [
            //     'attribute' => 'pet.name',
            //     'label' => 'Pet name',
            // ],
            [
                'attribute' => 'vaccine.name',
                'label' => 'Vaccine name',
            ],
            [
                'attribute' => 'vaccine.description',
                'label' => 'Vaccine description',
            ],
            'date_given',
            'notes',
        ],
    ]) ?>

</div>
