<?php

/** @var yii\web\View $this */

$this->title = 'My Pet Application';
?>
<style>
    body {
      background-image: url('<?= Yii::$app->request->baseUrl ?>/images/IMG_20220904_135713.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }
    .overlay-text {
        position: absolute;
        top: 15%;
        left: 21%;
        transform: translate(-20%, -20%);
        color: white;
        font-size: 36px;
        font-weight: bold;
        text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
    }
  </style>
<div class="site-index">
    <div class="overlay-text">
        Welcome to My Pet Application! 🐾
    </div>
</div>
