<?php

use yii\helpers\Html;
use yii\grid\GridView;
//use yii\widgets\Pjax;
use frontend\Models\Typeofdocuments;
use common\Models\User;
use common\Models\UserProfile;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\Models\DocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="documents-index">
    <p>
        <!--?= Html::a('Create Documents', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <!--?php Pjax::begin(); ?-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
        Modal::begin([
            //'header' => '<h4>Preview</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
            'footer' => Html::a('Download PDF', '/ilisanan', ['class' => 'btn btn-primary download-pdf'],
                ['target' => '_blank'],
            ),
        ]);

        //return Html::a(Html::img('data:image/png;base64,'.base64_encode($blob), ['alt' => 'My image','class' => 'border preview', 'id'=>$data->filename, 'value'=>Url::to("index.php?r=documents/create")]) , 
        //     ['documents/pdf','id' => $data->id],
        //     ['target' => '_blank'],
         //);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [

                'attribute' => 'pdf',
    
                'format' => 'raw',
    
                'label' => 'File',
 
    
                'value' => function ($data) {
 
                     
                    $img = new Imagick(Yii::getAlias('@archived/'.$data->filename.'.pdf[0]'));
                    $img->resizeImage( 100, 100, imagick::FILTER_LANCZOS, 0);
                    $img->setImageFormat( "png" );
                    $blob = $img->getImageBlob();

                    return Html::img('data:image/png;base64,'.base64_encode($blob), ['alt' => 'My image','class' => 'border preview ','cursor'=>'pointer', 'id'=>$data->filename, 'value'=>$data->id]);  
                     
                   
                },
                  
            ],
            'title',
            [       
                'attribute' => 'type',
                'value' => 'type0.doc_name',
                'filter'=>ArrayHelper::map(Typeofdocuments::find()->asArray()->all(), 'id', 'doc_name'),
            ],
            'code',
            [       
                'attribute' => 'created_by',
                'label' => 'Uploaded by',
                'value' => function ($data) {
    
                     $userProfile =  User::find()
                     ->with('userProfile')
                     ->where(['id' => $data->created_by])
                     ->one();

                     return $userProfile->userProfile->getFullName();
                },           
            ],
            [       
                'attribute' => 'updated_by',
                'label' => 'Updated by',
                'value' => function ($data) {
    
                     $userProfile =  User::find()
                     ->with('userProfile')
                     ->where(['id' => $data->updated_by])
                     ->one();

                     return $userProfile->userProfile->getFullName();
                },           
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    return date("d-M-Y",  strtotime($model->created_at));
                },
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'created_at',
                    'language' => 'eng',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'format' => 'html',
            ],   
            [
                'attribute' => 'updated_at',
                'value' => function($model){
                    return date("d-M-Y",  strtotime($model->updated_at));
                },
                'filter' => \yii\jui\DatePicker::widget([
                    'model'=>$searchModel,
                    'attribute'=>'updated_at',
                    'language' => 'eng',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'format' => 'html',
            ], 
            ['class' => 'yii\grid\ActionColumn'],          
        ],
    ]); ?>

    <!--?php Pjax::end(); ?-->

</div>

<?php 
$style= <<< CSS

    html{
        font-size: 1rem;
        line-height: 1.5;
    }

    img{
        cursor: pointer; 
    }

 CSS;
 $this->registerCss($style);
?>

<?php

$js = <<<JS
    $(".preview").click(function(){
        var imgId =this.id;
        $.ajax({
        url: "documents/preview",
        type: "post",
        data: {"filename":imgId},
        success: function (response) {
           // You will get response from your PHP page (what you echo or print)
           $('#modal').modal('show')
           .find('#modalContent')
           .html(response);
           $("#modal").removeClass("fade");
           $(".modal-dialog").addClass('modal-dialog-scrollable');
           $("a.download-pdf").attr("href", "/documents/pdf?filename="+imgId);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            }
        });
    });
JS;

$this->registerJs($js);

?>
