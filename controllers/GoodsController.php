<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Category;
use app\models\Goods;
use app\models\GoodsImages;
use app\models\GoodsSearch;
use app\models\Orders;
use app\models\Subcategory;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
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
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Lists all Goods models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $category = Category::find()->orderBy(['title' => SORT_ASC])->all();
        $subcategory = Subcategory::find()->orderBy(['title' => SORT_ASC])->all();

        return $this->render('index', [
            'category' => $category,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'subcategory' => $subcategory,
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Goods();
        $category = Category::find()->orderBy(['title' => SORT_ASC])->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validateUrlKey()) {

                    $model->author = $model->author == '' ? null : $model->author;
                    $model->year = $model->year == '' ? null : $model->year;
                    $model->lang = $model->lang == '' ? null : $model->lang;

                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Операція успішна.');

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    $errorMsg = 'Допускаються символи "A-Za-z0-9._-".';
                    $model->addError('url_key', $errorMsg);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'category' => $category,
            'model' => $model,
            'subcategory' => null,
        ]);
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category = Category::find()->orderBy(['title' => SORT_ASC])->all();

        if (Subcategory::findOne(['category_id' => $model->category_id]) !== null) {
            $subcategory = Subcategory::find()->where(['category_id' => $model->category_id])->orderBy(['title' => SORT_ASC])->all();
        } else {
            $subcategory = Subcategory::find()->orderBy(['title' => SORT_ASC])->all();
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->validateUrlKey()) {
                $model->author = $model->author == '' ? null : $model->author;
                $model->year = $model->year == '' ? null : $model->year;
                $model->lang = $model->lang == '' ? null : $model->lang;

                if (Subcategory::findOne(['category_id' => $model->category_id]) === null) {
                    $model->subcategory_id = null;
                }

                if (($model->hide === "Так") || ($model->available === "Ні")) {
                    $cart = Cart::find()->where(['good_id' => $model->id])->all();
                    foreach ($cart as $item) {
                        $item->delete();
                    }
                }

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Операція успішна.');

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $errorMsg = 'Допускаються символи "A-Za-z0-9._-".';
                $model->addError('url_key', $errorMsg);
            }
        }

        return $this->render('update', [
            'category' => $category,
            'model' => $model,
            'subcategory' => $subcategory,
        ]);
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Orders::findOne(['good_id' => $model->id]) === null) {
            $goods_images = GoodsImages::find()->where(['good_id' => $id])->all();
            foreach ($goods_images as $item) {
                $img_param = explode('.', $item->image);

                unlink('img/goods/' . $item->image);
                unlink('img/goods/' . $img_param[0] . '.webp');
            }

            $model->delete();

            Yii::$app->session->setFlash('success', 'Операція успішна.');
        } else {
            Yii::$app->session->setFlash('warning', 'Товар є в замовленнях, ви не можете його видалити, але можна приховати його.');
        }



        return $this->redirect(['index']);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
