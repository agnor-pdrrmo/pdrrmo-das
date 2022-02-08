<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\Models\Typeofdocuments;
use common\Models\User;
use common\Models\UserProfile;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\Models\DocumentsSearch */
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

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [

                'attribute' => 'pdf',
    
                'format' => 'html',
    
                'label' => 'File',
    
                'value' => function ($data) {
    
                    return Html::a('PDF', [
                        'documents/pdf',
                        'id' => $data->id,
                    ], [
                        'class' => 'btn btn-primary',
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
