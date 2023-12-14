<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Goods;
use app\models\OrderForm;
use app\models\Orders;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Orders model.
 */
class OrderController extends Controller
{
    public $layout = 'main';
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
     * Create new Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->id;
        $order_id = date("ym") . time();
        $cart = Cart::find()->where(['user_key' => Yii::$app->params['user_key']])->all();

        if (count($cart) > 0) {

            $model = new OrderForm();

            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                    $user_info = '<p><b>Замовник:</b> ' . $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name . '</p>
                                  <p><b>Телефон:</b> <a href="tel:' . $model->phone . '">' . $model->phone . '</a></p>';

                    if ($model->delivery_info == '') {
                        $delivery = $model->delivery;
                    } else {
                        $delivery = $model->delivery . ' (' . $model->delivery_info . ')';
                    }

                    $payment = $model->payment;

                    $products_list = [];
                    foreach ($cart as $item) {
                        $order = new Orders();

                        $order->order_id = $order_id;
                        $order->user_info = $user_info;
                        $order->good_id = $item->good_id;
                        $order->count = $item->count;
                        $order->good_price = Goods::findOne(['id' => $item->good_id]) !== null ? Goods::findOne(['id' => $item->good_id])->price : 0;
                        $order->price = $item->count * $order->good_price;
                        $order->payment = $payment;
                        $order->delivery = $delivery;

                        $products_list_item = [
                            'product_id' => Goods::findOne(['id' => $item->good_id]) !== null ? str_replace('PRC-', '', Goods::findOne(['id' => $item->good_id])->articul) : 0,
                            'price'      => $order->good_price,
                            'count'      => $order->count,
                        ];
                        array_push($products_list, $products_list_item);

                        if ($order->save()) {
                            $item->delete();
                        }
                    }

                    $products = urlencode(serialize($products_list));
                    $sender = urlencode(serialize($_SERVER));

                    $data = array(
                        'key'             => '5a6d51dacd0826fbe4f78930d48ae84f',
                        'order_id'        => $order_id,
                        'country'         => 'UA',
                        'office'          => '1',
                        'products'        => $products,
                        'bayer_name'      => $model->first_name . ' ' . $model->middle_name . '  ' . $model->last_name,
                        'phone'           => $model->phone,
                        'email'           => isset($_REQUEST['email']) ? $_REQUEST['email'] : 'null',
                        'comment'         => 'Оплата: ' . $payment . '. Доставка: ' . $delivery . '.',
                        'delivery'        => isset($_REQUEST['delivery']) ? $_REQUEST['delivery'] : '',
                        'delivery_adress' => $delivery,
                        'payment'         => isset($_REQUEST['payment']) ? $_REQUEST['payment'] : '',
                        'sender'          => $sender,
                        'utm_source'      => isset($_SESSION['utms']['utm_source']) ? $_SESSION['utms']['utm_source'] : '',
                        'utm_medium'      => isset($_SESSION['utms']['utm_medium']) ? $_SESSION['utms']['utm_medium'] : '',
                        'utm_term'        => isset($_SESSION['utms']['utm_term']) ? $_SESSION['utms']['utm_term'] : '',
                        'utm_content'     => isset($_SESSION['utms']['utm_content']) ? $_SESSION['utms']['utm_content'] : '',
                        'utm_campaign'    => isset($_SESSION['utms']['utm_campaign']) ? $_SESSION['utms']['utm_campaign'] : '',
                        'additional_1'    => 'Сайт poruch.store',
                        'additional_2'    => '',
                        'additional_3'    => '',
                        'additional_4'    => ''
                    );

                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, 'http://davidch.lp-crm.biz/api/addNewOrder.html');
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $out = curl_exec($curl);
                    curl_close($curl);

                    $body = '<p>Нове замовлення на сайті ' . Yii::$app->name . '.<br>
                                Номер замовлення: ' . $order_id . '<br>
                                Замовник: ' . $model->first_name . ' ' . $model->middle_name . '  ' . $model->last_name . '<br>
                                Телефон: ' . $model->phone . '</p>';

                    Yii::$app->mailer->compose()
                        ->setTo('poruch.zayavka@gmail.com')
                        ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name . ' mailer'])
                        ->setSubject('Нове замовлення на сайті ' . Yii::$app->name)
                        ->setHtmlBody($body)
                        ->send();

                    Yii::$app->session->setFlash('order-success', 'Замовлення успішно оформлено.');

                    return $this->redirect(['/site/thank']);
                }
            }

            return $this->render('index', [
                'cart' => $cart,
                'model' => $model,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
