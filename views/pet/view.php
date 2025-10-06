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
<style>
    .pet-photo img {
        border: 2px solid #ccc;
        border-radius: 8px;
        transition: transform 0.2s;
    }
    .pet-photo img:hover {
        transform: scale(1.05);
        border-color: #007bff;
    }
</style>
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
        <?= Html::a('Gallery', ['photo/photos', 'pet_id' => $model->pet_id], ['class' => 'btn btn-info']) ?>
    </p>

    <?php if ($model->photo && file_exists(Yii::getAlias('@webroot') . '/' . $model->photo)): ?>
        <div class="pet-photo mb-3" data-cy="petView-photo">
            <img src="<?= Yii::getAlias('@web') . '/' . $model->photo ?>" 
                class="img-thumbnail" 
                style="max-width:200px; max-height:200px;" 
                alt="Pet photo"
                onclick="openModal('<?= Yii::getAlias('@web') . '/' . $model->photo ?>')">
        </div>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'options' => [
            'class' => 'table table-bordered detail-view',
            'data-cy' => 'petView-detailView-table',
        ],
        'attributes' => [
            // 'pet_id',
            // [
            //     'label' => 'Photo',
            //     'attribute' => 'photo',
            //     'format' => 'html',
            //     'value' => function($item) {
            //         if(!$item->photo){
            //             return NULL;
            //         }
            //         $path = Yii::getAlias('@web');
            //         $tag = '<img src="'. $path . '/' . $item->photo. '" style="max-width:75px; max-height:75px;" />';
            //         return $tag;
            //     }
            // ],
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
            'query' => $model->getPetVaccines()->joinWith('vaccine'), // connection from Pet to PetVaccine
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'attributes' => [
                    'date_given',
                    'vaccine.name' => [
                        'asc' => ['vaccine.name' => SORT_ASC],
                        'desc' => ['vaccine.name' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['date_given' => SORT_DESC],
            ],
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

<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body p-0 text-center">
        <span class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></span>
        <img id="modalImage" src="" alt="Pet photo" class="img-fluid rounded shadow">
      </div>
    </div>
  </div>
</div>

<script>
function openModal(src) {
    document.getElementById("modalImage").src = src;
    var myModal = new bootstrap.Modal(document.getElementById('photoModal'));
    myModal.show();
}
</script>
