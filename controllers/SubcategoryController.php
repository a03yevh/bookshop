<?php

namespace app\controllers;

use app\models\Category;
use app\models\Items;
use app\models\Subcategory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SubcategoryController implements the CRUD actions for Subcategory model.
 */
class SubcategoryController extends Controller
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
                    'only' => ['index', 'view', 'create', 'update', 'delete'],
                    'rules' => [
                        [
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'allow' => true,
                            'roles' => ['manager'],
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
     * Lists all Subcategory models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $category = $this->findCategory($id);

        $dataProvider = new ActiveDataProvider([
            'query' => Subcategory::find()->where(['category_id' => $id]),
            'sort' => [
                'defaultOrder' => [
                    'title' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subcategory model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $category = $this->findCategory($model->category_id);

        return $this->render('view', [
            'category' => $category,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Subcategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $category = $this->findCategory($id);
        $model = new Subcategory();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validateUrlKey()) {

                    $model->category_id = $id;

                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Операція успішна.');

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    $errorMsg = 'Допускаються символи "A-Za-z0-9._-".';
                    $model->addError('url_key', $errorMsg);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'category' => $category,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Subcategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $category = $this->findCategory($model->category_id);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validateUrlKey()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Операція успішна.');

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    $errorMsg = 'Допускаються символи "A-Za-z0-9._-".';
                    $model->addError('url_key', $errorMsg);
                }
            }
        }

        return $this->render('update', [
            'category' => $category,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Subcategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $items = Items::find()->where(['category_id' => $id])->all();
        if (count($items) > 0) {
            Yii::$app->session->setFlash('warning', 'Неможливо видалити підкатегорію, якій є обʼєкти.');
        } else {
            $model->delete();

            Yii::$app->session->setFlash('success', 'Операція успішна.');
        }

        return $this->redirect(['index', 'id' => $model->category_id]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCategory($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Finds the Subcategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Subcategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subcategory::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
