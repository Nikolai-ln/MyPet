<?php

namespace app\controllers;

use app\models\Pet;
use app\models\PetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
        $searchModel = new PetSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

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
        $model = new Pet();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'pet_id' => $model->pet_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'pet_id' => $model->pet_id]);
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
