<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
            // 'user_id',
        ],
    ]) ?>

</div>
