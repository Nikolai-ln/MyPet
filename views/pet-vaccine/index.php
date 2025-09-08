<?php

use app\models\PetVaccine;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PetVaccineSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pet Vaccines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-vaccine-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pet Vaccine', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'pet_vaccine_id',
            'pet_id',
            'vaccine_id',
            'date_given',
            'notes',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PetVaccine $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'pet_vaccine_id' => $model->pet_vaccine_id]);
                 }
            ],
        ],
    ]); ?>


</div>
