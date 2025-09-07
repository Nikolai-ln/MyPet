<?php

namespace app\controllers;

use app\models\Vaccine;
use app\models\VaccineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * VaccineController implements the CRUD actions for Vaccine model.
 */
class VaccineController extends Controller
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
                                return !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin();
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
     * Lists all Vaccine models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VaccineSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vaccine model.
     * @param int $vaccine_id Vaccine ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($vaccine_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($vaccine_id),
        ]);
    }

    /**
     * Creates a new Vaccine model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Vaccine();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'vaccine_id' => $model->vaccine_id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Vaccine model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $vaccine_id Vaccine ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($vaccine_id)
    {
        $model = $this->findModel($vaccine_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'vaccine_id' => $model->vaccine_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Vaccine model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $vaccine_id Vaccine ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($vaccine_id)
    {
        $this->findModel($vaccine_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Vaccine model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $vaccine_id Vaccine ID
     * @return Vaccine the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($vaccine_id)
    {
        if (($model = Vaccine::findOne(['vaccine_id' => $vaccine_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
