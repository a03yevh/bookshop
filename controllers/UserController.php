<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\Orders;
use app\models\PasswordForm;
use app\models\User;
use Yii;
use app\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                    'only' => ['index', 'managers', 'banned', 'view', 'profile', 'update', 'update-profile', 'ban', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'managers', 'banned', 'view', 'update', 'ban', 'delete'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'actions' => ['profile', 'update-profile'],
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
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user_arr = [];
        $users = AuthAssignment::find()->where(['<>','item_name', 'admin'])->all();
        foreach ($users as $item) {
            array_push($user_arr, $item->user_id);
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $user_arr, 10);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all managers User models.
     *
     * @return string
     */
    public function actionManagers()
    {
        $user_arr = [];
        $managers = AuthAssignment::find()->where(['item_name' => 'manager'])->all();
        foreach ($managers as $item) {
            array_push($user_arr, $item->user_id);
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $user_arr, 10);

        return $this->render('managers', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all banned User models.
     *
     * @return string
     */
    public function actionBanned()
    {
        $user_arr = [];
        $users = AuthAssignment::find()->where(['<>', 'item_name', 'admin'])->all();
        foreach ($users as $item) {
            array_push($user_arr, $item->user_id);
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $user_arr, 99);

        return $this->render('banned', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->checkAdmin($id);

        $model = $this->findModel($id);

        $role = AuthAssignment::findOne(['user_id' => $id])->item_name;

        return $this->render('view', [
            'model' => $model,
            'role' => $role,
        ]);
    }

    /**
     * Displays a single User model.
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionProfile()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);
        $password = new PasswordForm();

        $role = AuthAssignment::findOne(['user_id' => $id])->item_name;

        if ($this->request->isPost) {
            if ($password->load($this->request->post())) {
                if ($password->checkPassword()) {
                    $model->setPassword($password->password);

                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Пароль успішно змінено.');

                        return $this->refresh();
                    }
                } else {
                    Yii::$app->session->setFlash('danger', 'Помилка при обробці форми. Паролі відрізняються.');
                    $errorMsg = 'Паролі відрізняються.';
                    $password->addError('password', $errorMsg);
                }
            }
        }

        return $this->render('profile', [
            'model' => $model,
            'password' => $password,
            'role' => $role,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->checkAdmin($id);

        $model = $this->findModel($id);

        $role = AuthAssignment::findOne(['user_id' => $id])->item_name;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if ($model->checkEmail()) {
                Yii::$app->session->setFlash('success', 'Операція успішна.');

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errorMsg = 'E-mail вже занято.';
                $model->addError('email', $errorMsg);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'role' => $role,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'profile' page.
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateProfile()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModel($id);

        $role = AuthAssignment::findOne(['user_id' => $id])->item_name;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            if ($model->checkEmail()) {
                Yii::$app->session->setFlash('success', 'Операція успішна.');

                return $this->redirect(['profile']);
            } else {
                $errorMsg = 'E-mail вже занято.';
                $model->addError('email', $errorMsg);
            }
        }

        return $this->render('update-profile', [
            'model' => $model,
            'role' => $role,
        ]);
    }

    /**
     * Change status an existing User model.
     * If ban is successful, the browser will be redirected to the 'banned' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBan($id)
    {
        $this->checkAdmin($id);

        $model = $this->findModel($id);

        $model->status = $model->status === 99 ? 10 : 99;
        $model->generateAuthKey();
        $msg = $model->status === 99 ? 'Користувача успішно заблоковано.' : 'Користувача успішно розблоковано.';

        if ($model->save()) {
            Yii::$app->session->setFlash('success', $msg);

            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    /**
     * Change role an existing User model.
     * If changing is successful, the browser will be redirected to the 'manager' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChangeRole($id)
    {
        $this->checkAdmin($id);

        $model = $this->findModel($id);

        $role = AuthAssignment::findOne(['user_id' => $id]);
        $role->item_name = $role->item_name === 'manager' ? 'client' : 'manager';
        $msg = $role->item_name === 'manager' ? 'Менеджера назначено.' : 'Менеджера видалено.';

        if ($role->save()) {
            Yii::$app->session->setFlash('success', $msg);

            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->checkAdmin($id);

        $model = $this->findModel($id);

        if (Orders::findOne(['user_id' => $model->id]) === null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Операція успішна.');
        } else {
            Yii::$app->session->setFlash('warning', 'Користувач вже робив замовлення, ви не можете його видалити, але можна деактивувати його його, додавши в бан.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function checkAdmin($id)
    {
        if ((int)$id === 1) {
            throw new NotFoundHttpException('Запитувана сторінка не існує.');
        }
    }

    public function checkRole($id, $role)
    {
        if ((AuthAssignment::findOne(['item_name' => $role, 'user_id' => $id])) === null) {
            throw new NotFoundHttpException('Запитувана сторінка не існує.');
        }
    }
}
