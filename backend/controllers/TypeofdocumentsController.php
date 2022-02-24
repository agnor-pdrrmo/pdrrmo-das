<?php

namespace backend\controllers;

use Yii;
use backend\models\Typeofdocuments;
use backend\models\TypeofdocumentsSearch;
use backend\models\Documents;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TypeofdocumentsController implements the CRUD actions for Typeofdocuments model.
 */
class TypeofdocumentsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Typeofdocuments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TypeofdocumentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Typeofdocuments model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Typeofdocuments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('administrator')) {
            $model = new Typeofdocuments();

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }
    
            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.')); 
        }

        
    }

    /**
     * Updates an existing Typeofdocuments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        if (Yii::$app->user->can('admin') || Yii::$app->user->can('administrator')) {
            $model = $this->findModel($id);

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
    
            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.')); 
        }
        
    }

    /**
     * Deletes an existing Typeofdocuments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('administrator')) {
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.')); 
        }
        
    }

    public function actionCode($id){

        if($this->request->isAjax){

            $countDocuments = Documents::find()
                ->count();

            $countTypeDocuments = Typeofdocuments::find()
                ->where(['id' => $id])
                ->count();
            
            $codeTypeDocuments = Typeofdocuments::find()
                ->where(['id' => $id])
                ->one();

            if($countTypeDocuments > 0 ){
                echo $codeTypeDocuments->code.'-'.date("Y").'-'.$countDocuments;
            }else{
                echo '';
            }

        }else{
            throw new \yii\web\MethodNotAllowedHttpException();
        }
       
    }

    /**
     * Finds the Typeofdocuments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Typeofdocuments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Typeofdocuments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
}
