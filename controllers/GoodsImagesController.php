<?php

namespace app\controllers;

use app\models\Goods;
use app\models\GoodsImages;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GoodsImagesController implements the CRUD actions for GoodsImages model.
 */
class GoodsImagesController extends Controller
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
     * Lists all GoodsImages models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $good = $this->findGood($id);

        $dataProvider = new ActiveDataProvider([
            'query' => GoodsImages::find()->where(['good_id' => $id]),
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'good' => $good,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GoodsImages model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $good = $this->findGood($model->good_id);

        return $this->render('view', [
            'good' => $good,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new GoodsImages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $good = $this->findGood($id);
        $model = new GoodsImages();
        $model->good_id = $id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if ($model->preview === 'Так') {
                    if (($img_preview = GoodsImages::findOne(['good_id' => $id, 'preview' => 'Так'])) !== null) {
                        $img_preview->preview = 'Ні';
                        $img_preview->save();
                    }
                }

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
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'good' => $good,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GoodsImages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $good = $this->findGood($model->good_id);
        $image = $model->image;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if ($model->preview === 'Так') {
                    if (($img_preview = GoodsImages::findOne(['good_id' => $model->good_id, 'preview' => 'Так'])) !== null) {
                        $img_preview->preview = 'Ні';
                        if ($img_preview->id !== $model->id) {
                            $img_preview->save();
                        }
                    }
                }

                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->imageFile) {
                    $image_param = explode('.', $image);
                    $image_name = md5(microtime() . rand(0, 9999));
                    $image_extension = $model->imageFile->extension;
                    $model->image = $image_name . '.png';

                    if ($model->save() && $model->upload($image_name, $image_extension)) {

                        unlink('img/goods/' . $image);
                        unlink('img/goods/' . $image_param[0] . '.webp');

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
            }
        }

        return $this->render('update', [
            'good' => $good,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GoodsImages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $image_param = explode('.', $model->image);

        unlink('img/goods/' . $model->image);
        unlink('img/goods/' . $image_param[0] . '.webp');

        $model->delete();

        Yii::$app->session->setFlash('success', 'Операція успішна.');

        return $this->redirect(['index', 'id' => $model->good_id]);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findGood($id)
    {
        if (($model = Goods::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    /**
     * Finds the GoodsImages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return GoodsImages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsImages::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }
}
