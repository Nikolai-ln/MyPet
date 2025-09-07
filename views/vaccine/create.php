<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Vaccine $model */

$this->title = 'Create Vaccine';
$this->params['breadcrumbs'][] = ['label' => 'Vaccines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vaccine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
