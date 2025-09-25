<?php

use app\models\Photo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PhotoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Pet $pet */

$this->title = 'Photos of ' . $pet->name;
$this->params['breadcrumbs'][] = ['label' => 'Pets', 'url' => ['pet/index']];
$this->params['breadcrumbs'][] = ['label' => $pet->name, 'url' => ['pet/view', 'pet_id' => $pet->pet_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .pet-photo-img {
        border: 2px solid #ccc;
        border-radius: 8px;
        transition: transform 0.2s, border-color 0.2s;
    }

    .pet-photo-img:hover {
        transform: scale(1.05);
        border-color: #007bff;
    }
</style>
<div class="photo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Upload Photo', ['photo/create', 'pet_id' => $pet->pet_id], ['class' => 'btn btn-success me-2']) ?>
        <?= Html::a('Gallery', ['photo/photos', 'pet_id' => $pet->pet_id], ['class' => 'btn btn-info']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'photo_id',
            [
                'attribute' => 'Image',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(
                        Html::img(
                            Yii::getAlias('@web/' . $model->path),
                            [
                                'class' => 'pet-photo-img', // добавяме клас за ховъра
                                'style' => 'max-width:150px; max-height:100px;',
                                'title' => 'View photo',
                            ]
                        ),
                        ['view', 'photo_id' => $model->photo_id]
                    );
                },
            ],
            [
                'attribute' => 'pet_id',
                'value' => function ($model) {
                    return $model->pet->name;
                },
                // 'filter' => false,
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Photo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'photo_id' => $model->photo_id]);
                 }
            ],
        ],
    ]); ?>


</div>
