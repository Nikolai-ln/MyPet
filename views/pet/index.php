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
<div class="pet-index" data-cy="petIndex-div">

    <h1 data-cy="petIndex-title"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add Pet', ['create'], ['class' => 'btn btn-success', 'data-cy' => 'petIndex-createPet-button']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'pet_id',
            [
                'attribute' => 'Photo',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a(
                        Html::img(
                            Yii::getAlias('@web/' . $model->photo),
                            [
                                'class' => 'pet-photo-img', // добавяме клас за ховъра
                                'style' => 'max-width:150px; max-height:100px;',
                                'title' => 'View',
                            ]
                        ),
                        ['view', 'pet_id' => $model->pet_id]
                    );
                },
            ],
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
