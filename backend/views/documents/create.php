<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\Models\Documents */

$this->title = 'Add document information';
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-create">

    <br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
