<?php

namespace app\controllers;

use app\models\Favorite;
use app\models\Goods;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FavoriteController implements the CRUD actions for Favorite model.
 */
class FavoriteController extends Controller
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
                    'only' => ['index', 'choose', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'choose', 'delete'],
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
     * Lists all Favorite models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity->id;
        $goods = Goods::find()->where(['hide' => 'Ні'])->all();
        $goods_id = [];
        foreach ($goods as $item) {
            array_push($goods_id, $item->id);
        }

        $model = Favorite::find()->where(['user_id' => $user_id, 'good_id' => $goods_id])->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Favorite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionChoose()
    {
        $good_id = Yii::$app->request->post('good_id');
        $user_id = Yii::$app->user->identity->id;
        if (($model = Favorite::findOne(['good_id' => $good_id, 'user_id' => $user_id])) !== null) {
            $model->delete();

            echo 'success delete';
        } else {
            $model = new Favorite();
            $model->user_id = $user_id;
            $model->good_id = $good_id;
            $model->save();

            echo 'success';
        }
    }

    /**
     * Deletes an existing Favorite model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Favorite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Favorite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favorite::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
