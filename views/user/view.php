<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->username;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($model->username) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'user_id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'user_id' => $model->user_id], [
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
            // 'user_id',
            'username',
            // 'password',
            'role',
        ],
    ]) ?>

    <h3>Pets of <?= Html::encode($model->username) ?></h3>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getPets(), // relation from User to Pet
        ]),
        'columns' => [
            'name',
            'type',
            'breed',
            'date_of_birth',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'user', // redirecting to PetController for CRUD
            ],
        ],
    ]); ?>

</div>
