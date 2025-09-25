<?php

namespace app\controllers;

use app\models\PetVaccine;
use app\models\PetVaccineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use Yii;

/**
 * PetVaccineController implements the CRUD actions for PetVaccine model.
 */
class PetVaccineController extends Controller
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
                            'matchCallback' => function ($rule, $action) {
                                return !Yii::$app->user->isGuest;
                            }
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
     * Lists all PetVaccine models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PetVaccineSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PetVaccine model.
     * @param int $pet_vaccine_id Pet Vaccine ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($pet_vaccine_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($pet_vaccine_id),
        ]);
    }

    /**
     * Creates a new PetVaccine model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($pet_id = null)
    {
        $model = new PetVaccine();

        if ($pet_id !== null) {
            $model->pet_id = $pet_id;
        }

        if (!Yii::$app->user->identity->isAdmin() && $model->pet_id) {
            $pet = $model->pet;
        if (!$pet || $pet->user_id != Yii::$app->user->id) {
                throw new \yii\web\ForbiddenHttpException('You are not allowed to add a vaccine to this pet.');
            }
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['pet/view', 'pet_id' => $model->pet_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PetVaccine model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $pet_vaccine_id Pet Vaccine ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($pet_vaccine_id)
    {
        $model = $this->findModel($pet_vaccine_id);

        if (!Yii::$app->user->identity->isAdmin() && $model->pet->user_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to edit this vaccine.');
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'pet_vaccine_id' => $model->pet_vaccine_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PetVaccine model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $pet_vaccine_id Pet Vaccine ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($pet_vaccine_id)
    {
         $model = $this->findModel($pet_vaccine_id);

         if (!Yii::$app->user->identity->isAdmin() && $model->pet->user_id != Yii::$app->user->id) {
            throw new ForbiddenHttpException('You are not allowed to delete this vaccine.');
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PetVaccine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $pet_vaccine_id Pet Vaccine ID
     * @return PetVaccine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($pet_vaccine_id)
    {
        $model = PetVaccine::findOne(['pet_vaccine_id' => $pet_vaccine_id]);

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
}
