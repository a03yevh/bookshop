<?php

namespace app\widgets;

use app\models\Goods;
use yii\db\Expression;

class GoodsWidget extends \yii\bootstrap5\Widget
{
    public $goods;
    public $good_id;

	public function init(){
        parent::init();

        $this->goods = Goods::find()
            ->where(['hide' => 'Ні'])
            ->andWhere(['<>', 'id', $this->good_id])
            ->orderBy([new Expression('rand()')])
            ->limit(4)
            ->all();
    }

	public function run() {
		return $this->render('goods/view', [
			'goods' => $this->goods,
		]);
	}
}
?>