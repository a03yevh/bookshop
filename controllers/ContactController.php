<?php

namespace app\controllers;

use app\models\FeedbackForm;
use app\models\Metadata;
use Yii;
use app\models\Contact;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
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
                    'only' => ['list', 'views', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['list', 'views', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['admin'],
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
     * Lists all Contact models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main';

        $address = Contact::find()->where(['type' => 'Адреса'])->orderBy(['value' => SORT_ASC])->all();
        $email = Contact::find()->where(['type' => 'Електронна адреса'])->orderBy(['value' => SORT_ASC])->all();
        $phone = Contact::find()->where(['type' => 'Телефон'])->orderBy(['value' => SORT_ASC])->all();
        $time = Contact::find()->where(['type' => 'Час роботи'])->orderBy(['value' => SORT_ASC])->all();
        $social = Contact::find()->where(['type' => 'Instagram'])->orWhere(['type' => 'Telegram'])->orWhere(['type' => 'Viber'])->orderBy(['type' => SORT_ASC])->all();

        $feedback = new FeedbackForm();

        if ($this->request->isPost) {
            if ($feedback->load($this->request->post())) {
                $subject = 'Зворотній звʼязок з сайту "' . Yii::$app->name . '"';
                $body = '<p><strong>Зворотній звʼязок з сайту "' . Yii::$app->name . '"</strong></p>
                    <hr>
                    <p><b>Ім’я:</b>: ' . $feedback->name . '</p>
                    <p><b>Телефон</b>: ' . $feedback->phone . '</p>
                    <hr>
                    <p>' . $feedback->message . '</p>';

                if ($feedback->contact($subject, $body)) {
                    Yii::$app->session->setFlash('success', 'Дякуємо за ваше звернення. Ми відповімо вам якомога швидше.');

                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('error', 'Виникла помилка, спробуйте надіслати форму ще раз.');
                }
            }
        }

        return $this->render('index', [
            'content' => Yii::$app->pageContent->gettingContent(),
            'address' => $address,
            'email' => $email,
            'feedback' => $feedback,
            'phone' => $phone,
            'social' => $social,
            'time' => $time,
        ]);
    }

    /**
     * Lists all Contact models.
     *
     * @return string
     */
    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Contact::find(),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'type' => SORT_ASC,
                    'value' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contact model.
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
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Contact();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->type == 'Електронна адреса') {
                    $errorMsg = 'Невірний формат e-mail.';
                }

                if ($model->type == 'Телефон') {
                    $errorMsg = 'Невірний формат номера телефону.';
                }

                if ($model->type == 'Instagram') {
                    $errorMsg = 'Невірний формат посилання на Instagram.';
                }

                if ($model->type == 'Telegram') {
                    $errorMsg = 'Невірний формат посилання на Telegram.';
                }

                if ($model->type == 'Viber') {
                    $errorMsg = 'Невірний формат номера телефону для Viber.';
                }

                if ($model->type == 'YouTube') {
                    $errorMsg = 'Невірний формат посилання на YouTube.';
                }

                if ($model->checkValue()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Операція успішна.');

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    $model->addError('value', $errorMsg);
                }

            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->type == 'Електронна адреса') {
                    $errorMsg = 'Невірний формат e-mail.';
                }

                if ($model->type == 'Телефон') {
                    $errorMsg = 'Невірний формат номера телефону.';
                }

                if ($model->type == 'Instagram') {
                    $errorMsg = 'Невірний формат посилання на Instagram.';
                }

                if ($model->type == 'Telegram') {
                    $errorMsg = 'Невірний формат посилання на Telegram.';
                }

                if ($model->type == 'Viber') {
                    $errorMsg = 'Невірний формат номера телефону для Viber.';
                }

                if ($model->type == 'YouTube') {
                    $errorMsg = 'Невірний формат посилання на YouTube.';
                }

                if ($model->checkValue()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Операція успішна.');

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    $model->addError('value', $errorMsg);
                }

            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Contact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Операція успішна.');

        return $this->redirect(['list']);
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
