<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $loginForm \yii\base\Model */

$this->beginContent('@app/views/layouts/base.php');
?>
<div class="container">
    
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="site-login">
                <h1 class="h2">Авторизация</h1>
                <p>Пожалуйста, авторизируйтесь:</p>

                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($loginForm, 'username') ?>
                <?= $form->field($loginForm, 'password')->passwordInput() ?>
<!--                --><?//= $form->field($loginForm, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent();