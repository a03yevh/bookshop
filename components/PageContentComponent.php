<?php
namespace app\components;

use app\models\Content;
use Yii;
use yii\base\Component;

class PageContentComponent extends Component {
    public function gettingContent() {
        $url = '/' . Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;

        return Content::findOne(['url' => $url]);
    }
}