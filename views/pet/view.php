<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Pet $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pet_id' => $model->pet_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'pet_id' => $model->pet_id], [
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
            // 'pet_id',
            'name',
            'type',
            'breed',
            'date_of_birth',
            'information',
            'owner',
            'address',
            'email',
            'phone_number'
            // 'user_id',
        ],
    ]) ?>

    <h3> Vaccines of <?= Html::encode($this->title) ?> </h3>

    <p>
        <?= Html::a('Add Vaccine', ['pet-vaccine/create', 'pet_id' => $model->pet_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getPetVaccines(), // connection from Pet to PetVaccine
        ]),
        'columns' => [
            'vaccine.name', // if we have a relation to Vaccine
            'date_given',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'pet-vaccine', // redirecting CRUD to PetVaccineController
            ],
        ],
    ]); ?>
</div>
