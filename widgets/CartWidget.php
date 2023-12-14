<?php

namespace app\widgets;

use app\models\Cart;
use Yii;
use yii\base\Widget;

class CartWidget extends Widget
{
    public $cart;

	public function init(){
        parent::init();

        $this->cart = null;
        $this->cart = Cart::find()->where(['user_key' => Yii::$app->params['user_key']])->all();
        $this->cart = count($this->cart) > 0 ? $this->cart : null;

    }

	public function run() {
		return $this->render('cart/view', [
			'cart' => $this->cart,
		]);
	}
}
?>