<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Photo $model */

$this->title = 'Upload Photo(s)';
$this->params['breadcrumbs'][] = ['label' => 'Photos of '.$model->pet->name, 'url' => ['photo/photos?pet_id='.$model->pet->pet_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
