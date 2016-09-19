<?php

/* @var $this yii\web\View */

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Личный кабинет'.' '.$model->last_name.' '.$model->first_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?= $this->render('_upload', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-lg-7">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
    <?= $this->render('delete-widget', [
        'model' => $model,
    ]) ?>

</div>
