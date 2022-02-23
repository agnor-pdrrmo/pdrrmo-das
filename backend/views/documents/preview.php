<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use backend\Models\Typeofdocuments;

/* @var $this yii\web\View */
/* @var $model backend\Models\Documents */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documents-preview">
  <?php
  
         $img = new Imagick(Yii::getAlias('@archived/'.$model->filename.'.pdf'));
         $num_page = $img->getnumberimages();
         
         for($x=0; $x<$num_page;$x++){
            $image = new Imagick(Yii::getAlias('@archived/'.$model->filename.'.pdf['.$x.']'));
            $image->setImageFormat( "png" );
            $blob = $image->getImageBlob();
            echo Html::img('data:image/png;base64,'.base64_encode($blob), ['alt' => 'My image','class' => 'border center']);
         }
  ?>


</div>


<?php 
$style= <<< CSS

   .center {
   display: block;
   margin-left: auto;
   margin-right: auto;
   }

 CSS;
 $this->registerCss($style);
?>