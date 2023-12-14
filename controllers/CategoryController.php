<?php

namespace app\controllers;

use app\models\Category;
use app\models\Goods;
use app\models\Subcategory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
            'sort' => [
                'defaultOrder' => [
                    'title' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validateUrlKey()) {
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                    if ($model->imageFile) {
                        $image_name = md5(microtime() . rand(0, 9999));
                        $image_extension = $model->imageFile->extension;
                        $model->image = $image_name . '.png';

                        if ($model->save() && $model->upload($image_name, $image_extension)) {
                            Yii::$app->session->setFlash('success', 'Операція успішна.');

                            return $this->redirect(['view', 'id' => $model->id]);
                        }

                    } else {
                        $errorMsg = 'Будь ласка, завантажте зображення.';
                        $model->addError('imageFile', $errorMsg);
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
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $image = $model->image;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validateUrlKey()) {
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                    if ($model->imageFile) {
                        $image_param = explode('.', $image);
                        $image_name = md5(microtime() . rand(0, 9999));
                        $image_extension = $model->imageFile->extension;
                        $model->image = $image_name . '.png';

                        if ($model->save() && $model->upload($image_name, $image_extension)) {

                            unlink('img/category/' . $image);
                            unlink('img/category/' . $image_param[0] . '.webp');

                            Yii::$app->session->setFlash('success', 'Операція успішна.');

                            return $this->redirect(['view', 'id' => $model->id]);
                        }

                    } else {
                        $model->image = $image;

                        if ($model->save()) {
                            Yii::$app->session->setFlash('success', 'Операція успішна.');

                            return $this->redirect(['view', 'id' => $model->id]);
                        }
                    }
                } else {
                    $errorMsg = 'Допускаються символи "A-Za-z0-9._-".';
                    $model->addError('url_key', $errorMsg);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $goods = Goods::find()->where(['category_id' => $id])->all();
        if (count($goods) > 0) {
            Yii::$app->session->setFlash('warning', 'Неможливо видалити категорію, якій є товари.');
        } else {
            $image_param = explode('.', $model->image);

            unlink('img/category/' . $model->image);
            unlink('img/category/' . $image_param[0] . '.webp');

            $model->delete();

            Yii::$app->session->setFlash('success', 'Операція успішна.');
        }

        return $this->redirect(['index']);
    }

    /**
     * @inheritdoc
     */
    public function actionGetSubcategories()
    {
        $category = Yii::$app->request->post('category');
        $list = '<option value="">Оберіть підкатегорію...</option>';

        if(($category == '') || ($category == null)) {
            echo $list;
        } else {
            $subcategory = Subcategory::find()->where(['category_id' => $category])->orderBy(['title' => SORT_ASC])->all();

            if (count($subcategory) === 0) {
                echo $list;
            } else {
                foreach ($subcategory as $value) {
                    $list .= '<option value="'. $value->id .'">'. $value->title .'</option>';
                }
                echo $list;
            }
        }
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
