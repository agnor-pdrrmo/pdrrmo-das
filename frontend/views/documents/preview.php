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
         //$img->resizeImage( 100, 100, imagick::FILTER_LANCZOS, 0);
        // $img->setImageFormat( "png" );
         //$blob = $img->getImageBlob();
         //$image =  '<img src="data:image/png;base64,'.base64_encode($blob).'"/>';

         //return Html::a(Html::img('data:image/png;base64,'.base64_encode($blob), ['alt' => 'My image','class' => 'border preview', 'id'=>$data->filename, 'value'=>Url::to("index.php?r=documents/create")]) , 
         //    ['documents/pdf','id' => $data->id],
         //    ['target' => '_blank'],
         //);

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