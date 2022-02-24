<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Typeofdocuments */

$this->title = 'Update Typeofdocuments: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Typeofdocuments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="typeofdocuments-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
