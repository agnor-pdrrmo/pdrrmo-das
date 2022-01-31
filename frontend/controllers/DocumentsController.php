<?php

namespace frontend\controllers;

use Yii;
use frontend\Models\Documents;
use frontend\Models\DocumentsSearch;
use frontend\Models\Files;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DocumentsController implements the CRUD actions for Documents model.
 */
class DocumentsController extends Controller
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
     * Lists all Documents models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Documents model.
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
     * Creates a new Documents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new Documents();
       
        
        if ($this->request->isPost) {

            if ($model->load($this->request->post())) { 
               
                // parse filename using explode and concat
                $fileExplode = explode(" ", $model->title);
                $fileConcat = "";
                foreach ($fileExplode as $value) {
                    $fileConcat = $fileConcat."".ucfirst(substr($value, 0, 2));
                }
                $fileConcat = $fileConcat."-".uniqid(time(), true)."-".time().rand(100,999);
                unset($value);

                //get the instance of the uploaded file         
                $model->file = UploadedFile::getInstance($model,'file');
                //setup value of filename
                $model->filename = $fileConcat;
                
                
                if($model->save()){
                    //Save file in archived folder
                    if($model->file->saveAs('archived/'.$fileConcat.'.'.$model->file->extension)){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }else{
                    $model->loadDefaultValues();
                }               
                
            }
        } else {
            $model->loadDefaultValues();
        }

        
        return $this->render('create', [
            'model' => $model,
        ]);

        
    }

    
    public function  actionPdf($id)
    {

        /*
        $model = Documents::findOne($id);

        
        
        // Might need to change '@app' for another alias
        $completePath = Yii::getAlias('@archived'.'/'.$model->filename.'.pdf');

        //return Yii::$app->response->sendFile($completePath, $model->filename.'.pdf');

        return Yii::$app->response->sendContentAsFile(
                $completePath, 
                $model->filename, 
                ['inline' => true, 'mimeType' => 'application/pdf']
        );
        */
        
        $model = Documents::findOne($id);
        $completePath = Yii::getAlias('@archived'.'/'.$model->filename.'.pdf');

        if(file_exists($completePath))

        {

            // Set up PDF headers

            header('Content-type: application/pdf');

            header('Content-Disposition: inline; filename="' . $model->filename . '"');

            header('Content-Transfer-Encoding: binary');

            header('Content-Length: ' . filesize($completePath));

            header('Accept-Ranges: bytes');


            // Render the file
            readfile($completePath);

            

        }

        else

        {

            // PDF doesn't exist so throw an error or something

        }

        

    }

    /**
     * Updates an existing Documents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Documents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Documents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Documents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Documents::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
