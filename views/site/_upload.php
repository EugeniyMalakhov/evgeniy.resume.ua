<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?= Html::img('@web/images/'.$model->avatar, ['alt' => $model->last_name, 'height' => 350, 'width' => 250])?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'avatar')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
