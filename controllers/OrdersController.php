<?php

namespace app\controllers;

use app\models\Goods;
use app\models\Orders;
use app\models\OrsersSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
                    'only' => ['index', 'all', 'view', 'view-item', 'update', 'update-item', 'delete-item'],
                    'rules' => [
                        [
                            'actions' => ['all','update', 'update-item', 'delete-item'],
                            'allow' => true,
                            'roles' => ['manager'],
                        ],
                        [
                            'actions' => ['index', 'view', 'view-item'],
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
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionAll()
    {
        $searchModel = new OrsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'action' => ['all'],
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Orders::find()->where(['order_id' => $id]),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewItem($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            $good = Goods::findOne(['id' => $model->good_id]);

            return $this->redirect(['/shop/good', 'id' => $good->url_key]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $orders = Orders::find()->where(['order_id' => $id])->all();

        if ($this->request->isPost && $model->load($this->request->post())) {
            foreach ($orders as $item) {
                $item->status = $model->status;
                $item->payment = $model->payment;
                $item->user_info = $model->user_info;
                $item->delivery = $model->delivery;
                $item->save();
            }
            Yii::$app->session->setFlash('success', 'Операція успішна.');

            return $this->redirect(['view', 'id' => $model->order_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateItem($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->price = $model->count * $model->good_price;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Операція успішна.');

                    return $this->redirect(['view', 'id' => $model->order_id]);
                }
            }

            return $this->render('update-item', [
                'model' => $model,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function actionDeleteItem($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            $model->delete();

            Yii::$app->session->setFlash('success', 'Операція успішна.');

            return $this->redirect(['view', 'id' => $model->order_id]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['order_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
