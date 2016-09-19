<?php
    use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
    <div class="pull-right btn-group">
        <?php echo Html::a('Удалить страницу', [
            '#'
        ], [
            'data-toggle' => 'modal',
            'data-target' => '#page-delete',
            'class' => 'btn btn-danger'
        ]); ?>

    </div>

    <?php
    Modal::begin([
        'size' => 'modal-md',
        'options' => [
            'id' => 'page-delete',
        ],
        'header' => '<h3>Подтверждение удаления</h3>',
    ]);

    echo 'Вы действительно хотите удалить страницу?';
    echo '<div class="input-group">';
    $form = ActiveForm::begin(['action' => '/site/delete?id='.$model->id]);
        echo Html::submitButton('Удалить', ['class' => 'btn btn-danger']);
    ActiveForm::end();
    echo '</div>';

    Modal::end();
    ?>