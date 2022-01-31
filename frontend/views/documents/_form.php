<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use frontend\Models\Typeofdocuments;

/* @var $this yii\web\View */
/* @var $model frontend\Models\Documents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documents-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=> 'multipart/form-data']]); ?>

    
    <?php
        $data = ArrayHelper::map(
                    Typeofdocuments::find()->asArray()->all(),
                    'id',
                    function($model) {
                        return $model['doc_des'];
                    }
                );
        echo $form->field($model, 'type')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select type of documents ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'title')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput() ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <br>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
