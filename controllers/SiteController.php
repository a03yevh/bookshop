<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\Category;
use app\models\ForgotPasswordForm;
use app\models\Goods;
use app\models\SignUpForm;
use app\models\Slider;
use app\models\User;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = Category::find()->orderBy([new Expression('rand()')])->limit(3)->all();
        $new_goods = Goods::find()->where(['hide' => 'Ні'])->orderBy(['created_at' => SORT_DESC])->limit(8)->all();
        $slider = Slider::find()->all();

        return $this->render('index', [
            'categories' => $categories,
            'content' => Yii::$app->pageContent->gettingContent(),
            'new_goods' => $new_goods,
            'slider' => $slider,
        ]);
    }

    /**
     * Displays thankpage.
     *
     * @return string
     */
    public function actionThank()
    {

        if (Yii::$app->session->hasFlash('order-success')) {
            return $this->render('thank', [
                'name' => 'Дякуємо за замовлення!',
                'message' => 'Ваше замовлення успішно оформлено. Зберігайте ваш телефон увімкненим, наш менеджер скоро з вами звʼяжеться.',
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (Yii::$app->request->isAjax) {

            $model = new LoginForm();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->login()) {
                    return $this->redirect(['/user/profile']);
                } else {
                    Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                    return \yii\widgets\ActiveForm::validate($model);
                }
            }
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * SignUp action.
     *
     * @return Response|string
     */
    public function actionSignUp()
    {
        if (Yii::$app->request->isAjax) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $link = $protocol . $_SERVER['HTTP_HOST'];

            $model = new SignUpForm();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if (($user = User::findOne(['email' => $model->email, 'status' => 0])) === null) {
                        $user = new User();
                    }

                    $user->email = $model->email;
                    $user->phone = $model->phone;
                    $user->first_name = $model->first_name;
                    $user->last_name = $model->last_name;
                    $user->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();

                    if ($user->save()) {
                        $user_id = User::findOne(['email' => $user->email])->id;
                        if (($add_role = AuthAssignment::findOne(['user_id' => $user_id])) === null) {
                            $add_role = new AuthAssignment();
                        }
                        $add_role->item_name = 'client';
                        $add_role->user_id = $user_id;

                        if ($add_role->save()) {
                            $subject = 'Реєстрація на сайті "' . Yii::$app->name . '"';
                            $body = '<p><strong>Реєстрація на сайті "' . Yii::$app->name . '"</strong></p>
                                         <p>Підтвердіть реєстрацію перейшовши за посиланням нижче.</p>
                                         <hr>
                                         <p><u>Посилання</u>: <a href="' . $link . '/site/confirmation/' . $user->password_reset_token . '">' . $link . '/site/confirmation/' . $user->password_reset_token . '</a></p>';


                            Yii::$app->session->setFlash('success', 'Заявку надіслано на ваш e-mail, підтвердіть її.');

                            if ($model->contact($subject, $body)) {

                                return $this->redirect(['/site/index']);
                            }
                        }
                    }
                } else {
                    Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                    return \yii\widgets\ActiveForm::validate($model);
                }
            }
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * SignUp confirmation action.
     *
     * @return string
     */
    public function actionConfirmation($id)
    {
        if (($model = User::findOne(['password_reset_token' => $id])) !== null) {
            $model->password_reset_token = null;
            $model->status = 10;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Пошту підтверджено, тепер ви можете авторизуватись.');

                return $this->redirect(['/site/index']);
            }
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Displays forgot-password page.
     *
     * @return string
     */
    public function actionForgotPassword()
    {

        if (Yii::$app->request->isAjax) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $link = $protocol . $_SERVER['HTTP_HOST'];

            $model = new ForgotPasswordForm();

            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $user = User::findOne(['email' => $model->email]);
                    $user->generatePasswordResetToken();

                    if ($user->save()) {
                        $subject = 'Відновлення паролю в додатку "' . Yii::$app->name . '"';
                        $body = '<p><strong>Відновлення паролю на сайті "' . Yii::$app->name . '"</strong></p>
                                <p>Підтвердіть відновлення перейшовши за посиланням нижче.</p>
                                <hr>
                                <p><u>Посилання</u>: <a href="' . $link . '/site/forgot-password/' . $user->password_reset_token . '">' . $link . '/site/forgot-password/' . $user->password_reset_token . '</a></p>';

                        if ($model->contact($subject, $body)) {
                            Yii::$app->session->setFlash('success', 'Заявку надіслано на ваш e-mail, підтвердіть її.');

                            return $this->redirect(['/site/index']);
                        }
                    }
                } else {
                    Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
                    return \yii\widgets\ActiveForm::validate($model);
                }
            }
        } else {
            if (($id = Yii::$app->request->get('id')) !== null) {
                if (($user = User::findOne(['password_reset_token' => $id])) !== null) {
                    $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
                    $max = 8;
                    $size = strlen($chars) - 1;
                    $password = null;

                    while ($max--)
                        $password .= $chars[rand(0, $size)];

                    $user->password_reset_token = null;
                    $user->setPassword($password);

                    $email = $user->email;

                    if ($user->save()) {
                        $subject = 'Відновлення паролю в додатку "' . Yii::$app->name . '"';
                        $body = '<p><strong>Відновлення паролю на сайті "' . Yii::$app->name . '"</strong></p>
                                <p>Ваш новий пароль для входу в систему. <b>Нікому не передавайте його.</b></p>
                                <hr>
                                <p><u>Пароль</u>: ' . $password . '</p>';


                        Yii::$app->mailer->compose()
                            ->setTo($email)
                            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name . ' mailer'])
                            ->setSubject($subject)
                            ->setHtmlBody($body)
                            ->send();

                        Yii::$app->session->setFlash('success', 'Новий пароль надіслано на ваш e-mail.');

                        return $this->redirect(['/site/index']);
                    }
                }
            }
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
