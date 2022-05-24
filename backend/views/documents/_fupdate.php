<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use backend\Models\Typeofdocuments;

/* @var $this yii\web\View */
/* @var $model backend\Models\Documents */
/* @var $form yii\widgets\ActiveForm */
$jblob = null;
?>

<div class="documents-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=> 'multipart/form-data']]); ?>

    
    <?php
        $data = ArrayHelper::map(
                    Typeofdocuments::find()->asArray()->all(),
                    'id',
                    function($model) {
                        return $model['doc_name'];
                    }
                );
        /*echo $form->field($model, 'type')->widget(Select2::classname(), [
            'data' => $data,
            'options' => ['placeholder' => 'Select type of documents ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'htmlOptions' => array(
                'onChange'=>
            );
        ]);
        */

        echo $form->field($model, 'type')->dropDownList($data, 
        ['prompt'=>'Select type of documents ...',
        'onchange'=>'             
                $.post( "'.urldecode(Yii::$app->urlManager->createUrl('typeofdocuments/code?id=')).'"+$(this).val(), function( data ) {
                    $( "input#documents-code" ).val( data );
                });
        ']);
    ?>

    <?= $form->field($model, 'code')->textInput() ?>

    <?= $form->field($model, 'title')->textArea(['maxlength' => true]) ?>

    <?php

        if(isset($model->getErrors()['file'][0])){
            echo '<div id="fileupload_wrapper">';           
            echo $form->field($model, 'file')->fileInput(['id' => 'file_upload_input']);
            echo Html::a('Cancel update', ['/documents'], ['class'=>'btn btn-danger']);
            //echo '<button type="button" class="btn btn-danger" onclick="cancelUpdateFile()">Cancel update file</button>';
            echo '</div>';
        }else{
            $img = new Imagick(Yii::getAlias('@archived/'.$model->filename.'.pdf[0]'));
            $img->resizeImage( 200, 200, imagick::FILTER_LANCZOS, 0);
            $img->setImageFormat( "png" );
            $blob = $img->getImageBlob();    
            $jblob = base64_encode($blob);  
    
            echo '<div class="wrapper_ni"><div class="alert">';
                    echo '<button type="button" class="close" > &times;</button>';
                    echo Html::img('data:image/png;base64,'.base64_encode($blob), ['alt' => 'My image','class' => 'border preview ','cursor'=>'pointer', 'id'=>$model->filename, 'value'=>$model->id]); 
            echo '</div></div>';  
        }
        
    ?>  

    <!--div id="fileupload_wrapper" class="invisible">            
        <--?= $form->field($model, 'file')->fileInput(['id' => 'file_upload_input']) ?>
        <button type="button" class="btn btn-danger">Cancel update file</button>
    </div-->
    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php 
$style= <<< CSS

    .wrapper_ni{
        width: 20%;
        height: auto;
    }
    .alert img{
        overflow: auto;
        width: 100%;
        height: auto;
    }
    .aler{
        background-color: white;
        border: none;
    }

 CSS;
 $this->registerCss($style);
?>


<?php
$script = <<<JS

    $(document).on('click', '.close' , function() {
        $(".alert").addClass("invisible");
        $("#fileupload_wrapper").removeClass("invisible");
        $('.wrapper_ni').html('<div id="fileupload_wrapper"><div class="form-group field-file_upload_input"> <label class="control-label" for="file_upload_input">Upload documents</label> <input type="hidden" name="Documents[file]" value=""><input type="file" id="file_upload_input" name="Documents[file]"> </div><button type="button" class="btn btn-danger" id="cancelFileUpdate">Cancel update file</button></div>');
    })

    
    $(document).on('click', '#cancelFileUpdate' , function() {
        $('.wrapper_ni').html('<div class="alert"> <button type="button" class="close"> ×</button>  <img  class="border preview " value="7"  src="data:image/png;base64,$jblob" alt="My image" cursor="pointer"> </div>');   
    })

    function cancelUpdateFile(){
        alert('cancel');
    }
    
JS;
$this->registerJs($script);
?>