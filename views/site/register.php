<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-create">
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <?= $this->render('_form_register', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>