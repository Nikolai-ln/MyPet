<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use app\models\Photo;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Pet $pet */

$this->title = 'Gallery of ' . $pet->name;
$this->params['breadcrumbs'][] = ['label' => 'Pets', 'url' => ['pet/index']];
$this->params['breadcrumbs'][] = ['label' => $pet->name, 'url' => ['pet/view', 'pet_id' => $pet->pet_id]];
$this->params['breadcrumbs'][] = 'Gallery';
?>
<div class="photo-gallery">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Upload Photo', ['photo/create', 'pet_id' => $pet->pet_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('List and Update Photos', ['photo/index', 'pet_id' => $pet->pet_id], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'Image',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img(
                        Yii::getAlias('@web/' . $model->path),
                        ['style' => 'max-width:150px; max-height:100px;']
                    );
                },
            ],
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'controller' => 'photo',
            //     'template' => '{view} {update} {delete}',
            // ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Photo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'photo_id' => $model->photo_id]);
                 }
            ],
        ],
    ]); ?>

</div>