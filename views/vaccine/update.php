<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Vaccine $model */

$this->title = 'Update Vaccine: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vaccines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'vaccine_id' => $model->vaccine_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vaccine-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
