<?php

namespace app\controllers;

use app\models\Category;
use app\models\Goods;
use app\models\GoodsDescription;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsDescriptionController implements the CRUD actions for GoodsDescription model.
 */
class GoodsDescriptionController extends Controller
{
    public $layout = 'dashboard';
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['index', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['manager'],
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
     * Lists all GoodsDescription models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $good = $this->findGood($id);
        $model = GoodsDescription::findOne(['good_id' => $id]);

        return $this->render('index', [
            'good' => $good,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new GoodsDescription model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $good = $this->findGood($id);
        if (($model = GoodsDescription::findOne(['good_id' => $id])) === null) {
            $model = new GoodsDescription();
            $model->good_id = $id;

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    Yii::$app->session->setFlash('success', 'Операція успішна.');

                    return $this->redirect(['index', 'id' => $good->id]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'good' => $good,
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }

    /**
     * Updates an existing GoodsDescription model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $good = $this->findGood($model->good_id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Операція успішна.');

            return $this->redirect(['index', 'id' => $good->id]);
        }

        return $this->render('update', [
            'good' => $good,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GoodsDescription model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->delete();

        Yii::$app->session->setFlash('success', 'Операція успішна.');

        return $this->redirect(['index', 'id' => $model->good_id]);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findGood($id)
    {
        if (($model = Goods::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Finds the GoodsDescription model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return GoodsDescription the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsDescription::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
