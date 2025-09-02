<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Login';
// $this->params['breadcrumbs'][] = $this->title;
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
    .site-login {
        background: rgba(255,255,255,0.8);
        /*color: white;*/
        padding: 20px;
        border-radius: 10px;
    }
  </style>
<div class="col-md-6 site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'options' => ['data-cy' => 'login-form'],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-5 form-control'],
            'errorOptions' => ['class' => 'invalid-feedback']
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'data-cy' => 'login-username']) ?>

        <?= $form->field($model, 'password')->passwordInput(['data-cy' => 'login-password']) ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"offset-lg-1 col-lg-5 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'inputOptions' => ['data-cy' => 'login-rememberMe-checkbox']]) ?>

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button', 'data-cy' => 'login-submit-btn']) ?>
                <a class="btn btn-primary" href="<?php echo \yii\helpers\Url::to(['/site/signup']) ?>">Sign Up</a>
                <br><br><a href="<?php echo \yii\helpers\Url::to(['/site/signup']) ?>"> Sign Up</a>
            </div>
        </div>

    <?php ActiveForm::end();
        // You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
        // To modify the username/password, please check out the code <code>app\models\User::$users</code>.
    ?>
    <div class="offset-lg-1" style="color:#999;">
    </div>
</div>
