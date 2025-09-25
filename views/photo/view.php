<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Photo $model */

$this->title = 'Photo ' . $model->photo_id;
$this->params['breadcrumbs'][] = ['label' => 'Photos of '.$model->pet->name, 'url' => ['photo/index?pet_id='.$model->pet->pet_id]];
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
<div class="photo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'photo_id' => $model->photo_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'photo_id' => $model->photo_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php if ($model->path && file_exists(Yii::getAlias('@webroot') . '/' . $model->path)): ?>
        <div class="pet-photo mb-3">
            <img src="<?= Yii::getAlias('@web') . '/' . $model->path ?>" 
                class="img-thumbnail" 
                style="max-width:200px; max-height:200px;" 
                alt="Pet photo"
                onclick="openModal('<?= Yii::getAlias('@web') . '/' . $model->path ?>')">
        </div>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'photo_id',
            // 'path',
            [
                'attribute' => 'pet_id',
                'value' => function ($model) {
                    return $model->pet->name;
                },
            ],
        ],
    ]) ?>

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