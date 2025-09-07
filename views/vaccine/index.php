<?php

use app\models\Vaccine;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\VaccineSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vaccines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vaccine-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Vaccine', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'vaccine_id',
            'name',
            'description',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Vaccine $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'vaccine_id' => $model->vaccine_id]);
                 }
            ],
        ],
    ]); ?>


</div>
