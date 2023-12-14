<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\ForgotPasswordForm;
use app\models\SignUpForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class DeliveryPaymentController extends Controller
{

    /**
     * Displays delivery-payment page.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'content' => Yii::$app->pageContent->gettingContent(),
        ]);
    }
}
