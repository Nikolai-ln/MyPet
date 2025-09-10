<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Pet $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Pets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pet-view" data-cy="petView-div">

    <h1 data-cy="petView-title"><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'pet_id' => $model->pet_id], ['class' => 'btn btn-primary', 'data-cy' => 'petView-update-btn']) ?>
        <?= Html::a('Delete', ['delete', 'pet_id' => $model->pet_id], [
            'class' => 'btn btn-danger',
            'data-cy' => 'petView-delete-btn',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-bordered detail-view',
            'data-cy' => 'petView-detailView-table',
        ],
        'attributes' => [
            // 'pet_id',
            [
                'label' => 'Photo',
                'attribute' => 'photo',
                'format' => 'html',
                'value' => function($item) {
                    if(!$item->photo){
                        return NULL;
                    }
                    $path = Yii::getAlias('@web');
                    $tag = '<img src="'. $path . '/' . $item->photo. '" style="max-width:75px; max-height:75px;" />';
                    return $tag;
                }
            ],
            [
                'attribute' => 'name',
                'contentOptions' => ['data-cy' => 'petView-detailView-name'],
            ],
            [
                'attribute' => 'type',
                'contentOptions' => ['data-cy' => 'petView-detailView-type'],
            ],
            [
                'attribute' => 'breed',
                'contentOptions' => ['data-cy' => 'petView-detailView-breed'],
            ],
            [
                'attribute' => 'date_of_birth',
                'contentOptions' => ['data-cy' => 'petView-detailView-dateOfBirth'],
            ],
            [
                'attribute' => 'information',
                'contentOptions' => ['data-cy' => 'petView-detailView-information'],
            ],
            [
                'attribute' => 'owner',
                'contentOptions' => ['data-cy' => 'petView-detailView-owner'],
            ],
            [
                'attribute' => 'address',
                'contentOptions' => ['data-cy' => 'petView-detailView-address'],
            ],
            [
                'attribute' => 'email',
                'contentOptions' => ['data-cy' => 'petView-detailView-email'],
            ],
            [
                'attribute' => 'phone_number',
                'contentOptions' => ['data-cy' => 'petView-detailView-phoneNumber'],
            ],
            // 'user_id',
        ],
    ]) ?>

    <h3 data-cy="petView-vaccines-title"> Vaccines of <?= Html::encode($this->title) ?> </h3>

    <p>
        <?= Html::a('Add Vaccine', ['pet-vaccine/create', 'pet_id' => $model->pet_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getPetVaccines(), // connection from Pet to PetVaccine
            'pagination' => ['pageSize' => 10],
        ]),
        'columns' => [
            'vaccine.name', // if we have a relation to Vaccine
            'date_given',
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $petVaccineModel, $key, $index, $column) {
                    return Url::toRoute(["/pet-vaccine/$action", 'pet_vaccine_id' => $petVaccineModel->pet_vaccine_id]);
                }
            ],
        ],
    ]); ?>
</div>
