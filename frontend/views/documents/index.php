<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\Models\Typeofdocuments;
use common\Models\User;
use common\Models\UserProfile;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel frontend\Models\DocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-index">


    <p>
        <?= Html::a('Create Documents', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <!--?php Pjax::begin(); ?-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--?php
        $img = new Imagick(Yii::getAlias('@archived'.'/AcOfEORETyOd-164326422361f238df8c21c4.33003292-1643264223214.pdf'));
        $img->resizeImage( 200, 200, imagick::FILTER_LANCZOS, 0);
        //$img->writeImage(Yii::getAlias('@archived'.'/Newimg.jpg'));
        $img->setImageFormat( "png" );
        $blob = $img->getImageBlob();
        echo '<img src="data:image/png;base64,'.base64_encode($blob).'"/>';
    ?-->

    <?php
        Modal::begin([
            'header' => '<h4>Preview</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
        ]);

        echo "<div> id='modalContent'></div>";

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
                    $image =  '<img src="data:image/png;base64,'.base64_encode($blob).'"/>';
    
                    return Html::a(Html::img('data:image/png;base64,'.base64_encode($blob), ['alt' => 'My image']) , [
                        'documents/pdf',
                        'id' => $data->id,
                    ], [
                        //'class' => 'btn btn-primary',
                        'target' => '_blank',
                    ]);  
                     
                   
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

<?php $style= <<< CSS

    html{
        font-size: 1rem;
        line-height: 1.5;
    }

 CSS;
 $this->registerCss($style);
?>
