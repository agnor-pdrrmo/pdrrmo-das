<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Typeofdocuments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="typeofdocuments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc_name')->textInput() ?>

    <?= $form->field($model, 'doc_des')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
