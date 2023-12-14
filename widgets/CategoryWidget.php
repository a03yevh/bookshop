<?php

namespace app\widgets;

use app\models\Category;

class CategoryWidget extends \yii\bootstrap5\Widget
{
    public $cat;
    public $count;

	public function init(){
        parent::init();

        $this->cat = Category::find()
            ->orderBy(['title' => SORT_ASC])
            ->limit(4);
    }

	public function run() {
		return $this->render('category/view', [
			'category' => $this->cat->all(),
			'count' => $this->cat->count(),
		]);
	}
}
?>