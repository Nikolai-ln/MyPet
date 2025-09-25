<?php

namespace app\controllers;

use app\models\Photo;
use app\models\PhotoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\Pet;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * PhotoController implements the CRUD actions for Photo model.
 */
class PhotoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
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
     * Lists all Photo models.
     *
     * @return string
     */
    public function actionIndex($pet_id = null)
    {
        $searchModel = new PhotoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        if ($pet_id !== null) {
            $params['PhotoSearch']['pet_id'] = $pet_id;
            $pet = \app\models\Pet::findOne($pet_id);
        } else {
            $pet = null;
        }

        if (!$pet || (Yii::$app->user->identity->role === 'user' && $pet->user_id != Yii::$app->user->id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pet' => $pet,
            'pet_id' => $pet_id,
        ]);
    }

    /**
     * Displays a single Photo model.
     * @param int $photo_id Photo ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($photo_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($photo_id),
        ]);
    }

    /**
     * Creates a new Photo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($pet_id)
    {
        $request = Yii::$app->request;

        $pet = \app\models\Pet::findOne($pet_id);

        if (!$pet || (Yii::$app->user->identity->role === 'user' && $pet->user_id != Yii::$app->user->id)) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        $model = new Photo();
        $model->scenario = 'create';
        $fileSuccess = NULL;
        $model->pet_id = $pet_id;

        $files = UploadedFile::getInstances($model, 'files');

        if($files) {
            foreach ($files as $file) {
                $model = new Photo();
            

                if ($request->isPost) {
                
                    $modelLoaded = $model->load($request->post());

                    if (!$modelLoaded) {
                        return $this->render('create', [
                            'model' => $model,
                            'errorMessage' => "Missing parameters!",
                        ]);
                    }
                    
                    $extension = pathinfo($file->name, PATHINFO_EXTENSION);
                    $photoPath = "uploads/".$model->pet->name . "." . Yii::$app->security->generateRandomString() . "." . $extension;
                    $fileSuccess = $file->saveAs($photoPath);
                    if ($file && !$fileSuccess) {
                        return $this->render('create', [
                            'model' => $model,
                            'errorMessage' => "Cannot write file to disk!",
                        ]);
                    }
                    if ($file && $fileSuccess) {
                        $model->setAttribute('path', $photoPath);
                        $model->save();
                    }
                }
            }

            if ($model->validate()) {
                return $this->redirect(['photo/index', 'pet_id' => $pet_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'errorMessage' => NULL,
        ]);

    }

    /**
     * Updates an existing Photo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $photo_id Photo ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($photo_id)
    {
        $model = $this->findModel($photo_id);
        $model->scenario = 'update';
        $request = Yii::$app->request;
        $fileSuccess = NULL;
        $photoPathOld = NULL;

        if ($request->isPost) {

            $modelLoaded = $model->load($request->post());

            if($model->path){
                $photoPathOld = Yii::$app->basePath.'/web/'.$model->path; //get the path to the existing file
            }

            if (!$modelLoaded) {
                return $this->render('update', [
                    'model' => $model,
                    'errorMessage' => "Missing parameters!",
                ]);
            }

            $files = UploadedFile::getInstances($model, 'files');

            if($files){
                foreach ($files as $file) {
                    $extension = pathinfo($file->name, PATHINFO_EXTENSION);
                    $photoPath = "uploads/".$model->pet->name . "." . Yii::$app->security->generateRandomString() . "." . $extension;
                    if(file_exists($photoPathOld)){
                        if(strcmp($photoPath, $photoPathOld) !== 0){
                            @unlink($photoPathOld);
                        }
                    }
                    $fileSuccess = $file->saveAs($photoPath);
                }
            }

            if ($files && !$fileSuccess) {
                return $this->render('update', [
                    'model' => $model,
                    'errorMessage' => "Cannot update file to disk!",
                ]);
            }

            if ($files && $fileSuccess){
                // save the path in the db column
                $model->setAttribute('path', $photoPath);
            }

            if ($model->validate() && $model->save()) {
                return $this->redirect(['photo/index', 'pet_id' => $model->pet->pet_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing Photo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $photo_id Photo ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($photo_id)
    {
        $model = $this->findModel($photo_id);
        $pet_id = $model->pet_id;
        $model->delete();

        return $this->redirect(['photo/index', 'pet_id' => $pet_id]);
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $photo_id Photo ID
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($photo_id)
    {
        $model = Photo::findOne(['photo_id' => $photo_id]);

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (Yii::$app->user->identity->role === 'user') {

            if (!$model->pet || $model->pet->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

        return $model;
    }

    public function actionPhotos($pet_id = null)
    {
        $pet = $pet_id ? \app\models\Pet::findOne($pet_id) : null;

        if (!$pet) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (Yii::$app->user->identity->role === 'user' && $pet->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $query = \app\models\Photo::find();

        if ($pet_id !== null) {
            $query->andWhere(['pet_id' => $pet_id]);
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $pet = $pet_id ? \app\models\Pet::findOne($pet_id) : null;

        return $this->render('photos', [
            'dataProvider' => $dataProvider,
            'pet' => $pet,
        ]);
    }

    public function actionGallery($pet_id = null)
    {
        $pet = $pet_id ? \app\models\Pet::findOne($pet_id) : null;

        if (!$pet) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (Yii::$app->user->identity->role === 'user' && $pet->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $query = \app\models\Photo::find();

        if ($pet_id !== null) {
            $query->andWhere(['pet_id' => $pet_id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('gallery', [
            'pet' => $pet,
            'dataProvider' => $dataProvider,
        ]);
    }
}
