<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Typeofdocuments */

$this->title = 'Create Typeofdocuments';
$this->params['breadcrumbs'][] = ['label' => 'Type of documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="typeofdocuments-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
