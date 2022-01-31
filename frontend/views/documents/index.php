<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\Models\Typeofdocuments;
use yii\helpers\ArrayHelper;
use common\Models\User;
use common\Models\UserProfile;

/* @var $this yii\web\View */
/* @var $searchModel frontend\Models\DocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'label' => 'Date upload',
                'value' => 'type0.doc_name',            
            ], 
            [       
                'attribute' => 'updated_at',
                'label' => 'Date update',
                'value' => 'type0.doc_name',            
            ],    
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <!--?php Pjax::end(); ?-->

</div>
