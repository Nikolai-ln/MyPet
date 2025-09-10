<?php

namespace app\controllers;

use app\models\Pet;
use app\models\PetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use Yii;

/**
 * PetController implements the CRUD actions for Pet model.
 */
class PetController extends Controller
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
     * Lists all Pet models.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role === 'admin') {
            $query = Pet::find();
        } else {
            $query = Pet::find()->where(['user_id' => Yii::$app->user->id]);
        }

        $searchModel = new PetSearch();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pet model.
     * @param int $pet_id Pet ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($pet_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($pet_id),
        ]);
    }

    /**
     * Creates a new Pet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Pet();
        $fileSuccess = NULL;

        if ($request->isPost) {
             $modelLoaded = $model->load($request->post());

             if (!$modelLoaded) {
                return $this->render('create', [
                    'model' => $model,
                    'errorMessage' => "Missing parameters!",
                ]);
            }
            // get the instance of the uploaded file
            $file = UploadedFile::getInstance($model, 'file');

            if ($file) {
                $photoPath = "uploads/".$model->name."-".$file->name;
                $fileSuccess = $file->saveAs($photoPath);
            }

            if ($file && !$fileSuccess) {
                return $this->render('create', [
                    'model' => $model,
                    'errorMessage' => "Cannot write file to disk!",
                ]);
            }

            if ($file && $fileSuccess) {
                // save the path in the db column
                $model->setAttribute('photo', $photoPath);
            }

            // if the user is not an admin we would link the current user
            if (Yii::$app->user->identity->role !== 'admin') {
                $model->user_id = Yii::$app->user->id;
            }

            if ($model->validate() && $model->save()) {
                return $this->redirect(['view', 'pet_id' => $model->pet_id]);
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
            'errorMessage' => NULL,
        ]);
    }

    /**
     * Updates an existing Pet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $pet_id Pet ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pet_id)
    {
        $model = $this->findModel($pet_id);
        $request = Yii::$app->request;

        if ($request->isPost) {

            $modelLoaded = $model->load($request->post());

            if (!$modelLoaded) {
                return $this->render('update', [
                    'model' => $model,
                    'errorMessage' => "Missing parameters!",
                ]);
            }
            // get the instance of the uploaded file
            $photoPath = $model->photo;
            $fileSuccess = true;
            $file = UploadedFile::getInstance($model, 'file');

            if($file){
                $photoPath = "uploads/".$model->name."-".$file->name;
                $fileSuccess = $file->saveAs($photoPath);
            }

            if (!$fileSuccess) {
                return $this->render('update', [
                    'model' => $model,
                    'errorMessage' => "Cannot update file to disk!",
                ]);
            }
            // save the path in the db column
            $model->setAttribute('photo', $photoPath);

            if ($fileSuccess && $model->validate() && $model->save()) {
                return $this->redirect(['view', 'pet_id' => $model->pet_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Pet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $pet_id Pet ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($pet_id)
    {
        $this->findModel($pet_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $pet_id Pet ID
     * @return Pet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($pet_id)
    {
        if (($model = Pet::findOne(['pet_id' => $pet_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
