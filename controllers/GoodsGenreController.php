<?php

namespace app\controllers;

use app\models\Goods;
use app\models\GoodsGenre;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsGenreController implements the CRUD actions for GoodsGenre model.
 */
class GoodsGenreController extends Controller
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
     * Lists all GoodsGenre models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $good = $this->findGood($id);

        $dataProvider = new ActiveDataProvider([
            'query' => GoodsGenre::find()->where(['good_id' => $id]),
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'good' => $good,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsGenre model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $good = $this->findGood($model->good_id);

        return $this->render('view', [
            'good' => $good,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new GoodsGenre model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $good = $this->findGood($id);
        $model = new GoodsGenre();
        $model->good_id = $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Операція успішна.');

                $this->updateGoodGenre($id);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'good' => $good,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GoodsGenre model.
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

            $this->updateGoodGenre($good->id);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'good' => $good,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GoodsGenre model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $good = $this->findGood($model->good_id);

        $model->delete();

        $this->updateGoodGenre($good->id);

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
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function updateGoodGenre($id)
    {
        if (($model = Goods::findOne(['id' => $id])) !== null) {
            $goods_genre = GoodsGenre::find()->where(['good_id' => $id])->all();

            if(count($goods_genre) > 0) {
                $genre = '';
                foreach ($goods_genre as $item) {
                    $genre .= ', ' . $item->value;
                }

                $model->genre = mb_strtolower(mb_substr($genre, 2));
            } else {
                $model->genre = null;
            }

            $model->save();

            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Finds the GoodsGenre model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return GoodsGenre the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsGenre::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
