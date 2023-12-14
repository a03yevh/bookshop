<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Goods;
use app\models\GoodsImages;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * FavoriteController implements the CRUD actions for Favorite model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
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
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) {
            $user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->id;
            $user_key = Yii::$app->params['user_key'];
            $good_id = Yii::$app->request->post('good_id');

            if (($model = Cart::findOne(['user_key' => $user_key, 'good_id' => $good_id])) === null) {
                $model = new Cart();
                $model->user_id = $user_id;
                $model->user_key = $user_key;
                $model->good_id = $good_id;
                $model->count = 1;
            } else {
                $model->count = $model->count + 1;
            }

            if ($model->save()) {
                return $this->countItems() . ';' . $model->id;
            }
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionChangeCount()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $count = Yii::$app->request->post('count');

            $model = $this->findModel($id);
            $model->count = intval($count);

            if ($model->save()) {
                $cart = Cart::find()->where(['user_key' => Yii::$app->params['user_key']])->all();
                $total_count = 0;
                foreach ($cart as $item) {
                    $total_count += $item->count * Goods::findOne(['id' => $item->good_id])->price;
                }
                return $total_count;
            }
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function actionMakeItem()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');

            $model = $this->findModel($id);
            $good = Goods::findOne(['id' => $model->good_id]);

            $goods_image = 'no-image.png';

            if (GoodsImages::find()->where(['good_id' => $good->id])->count() > 0) {
                if (($preview = GoodsImages::findOne(['good_id' => $good->id, 'preview' => 'Так'])) !== null) {
                    $goods_image = $preview->image;
                } else {
                    $preview = GoodsImages::findOne(['good_id' => $good->id]);
                    $goods_image = $preview->image;
                }
            }

            $image_param = explode('.', $goods_image);
            $price = number_format($good->price, 2, '.', ' ');

            return '<div class="cart-widget__item cart-widget__item-' . $model->id . '" id="cart-item-' . $model->id . '">
                        <picture class="cart-widget__item-image">
                            <source srcset="/img/goods/' . $image_param[0] . '.webp" type="image/webp">
                            ' . Html::img('@web/img/goods/' . $goods_image, ['alt' => $good->title, 'width' => 100, 'height' => 100]) . '
                        </picture>
    
                        <div class="cart-widget__item-info">
                            <a class="cart-widget__item-title" href="' . Yii::$app->urlManager->createUrl(['/shop/good/' . $good->url_key]) . '">' . $good->title . '</a>
    
                            <div class="cart-widget__item-ctrl">
                                <p class="cart-widget__item-price">' . $price . ' ₴ / шт.</p>
                                
                                <div class="cart-widget__item-count">
                                    <span class="cart-widget__item-count-minus" onclick="subtractCountGoods('. $model->id .')">-</span>
                                    <input class="cart-widget__item-count-input" type="text" id="item-count-' . $model->id . '" value="1" oninput="changeCountGoods('. $model->id .')" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    <span class="cart-widget__item-count-plus" onclick="addCountGoods(' . $model->id . ')">+</span>
                                </div>
                            </div>
    
                            <a class="cart-widget__item-delete" onclick="deleteFromCart(' . $model->id . ')" data-cart-item="' . $model->id . '">Видалити</a>
                        </div>
                    </div>';
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');

            $this->findModel($id)->delete();

            $cart = Cart::find()->where(['user_key' => Yii::$app->params['user_key']])->all();
            $total_count = 0;
            foreach ($cart as $item) {
                $total_count += $item->count * Goods::findOne(['id' => $item->good_id])->price;
            }

            return $this->countItems() . ';' . $total_count;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    protected function countItems()
    {
        $cart = Cart::find()->where(['user_key' => Yii::$app->params['user_key']])->all();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item->count;
        }
        return $count;
    }
}
