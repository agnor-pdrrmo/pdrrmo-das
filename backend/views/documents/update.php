<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\Models\Documents */

$this->title = 'Update Documents: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documents-update">
  
    <?= $this->render('_fupdate', [
        'model' => $model,
    ]) ?>

</div>
