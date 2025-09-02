<?php

use app\models\Pet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PetSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'My Pets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pet-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Pet', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'pet_id',
            'name',
            'type',
            'breed',
            'date_of_birth',
            // 'information',
            'owner',
            // 'address',
            //'user_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Pet $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'pet_id' => $model->pet_id]);
                 }
            ],
        ],
    ]); ?>


</div>
