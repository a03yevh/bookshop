<?php

namespace app\controllers;

use app\models\Category;
use app\models\Goods;
use app\models\GoodsCharacteristics;
use app\models\GoodsDescription;
use app\models\GoodsGenre;
use app\models\GoodsImages;
use app\models\Subcategory;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ShopController extends Controller
{

    /**
     * Displays shop page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = Category::find()->orderBy(['title' => SORT_ASC])->all();
        $genrises = GoodsGenre::find()->orderBy(['value' => SORT_ASC])->groupBy('value')->all();
        $publishers = Goods::find()->where(['hide' => 'Ні'])->orderBy(['publisher' => SORT_ASC])->groupBy('publisher')->all();

        $query = Goods::find()->where(['hide' => 'Ні']);

        $this->actionFilterGoods($query);
        $this->actionSortGoods($query);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $pages->pageSizeParam = false;
        $model = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'categories' => $categories,
            'genrises' => $genrises,
            'category' => null,
            'subcategory' => null,
            'model' => $model,
            'pages' => $pages,
            'publishers' => $publishers,
        ]);
    }

    /**
     * Displays search page.
     *
     * @return string
     */
    public function actionSearch()
    {
        $q = Yii::$app->request->get('q');
        $categories = Category::find()->orderBy(['title' => SORT_ASC])->all();
        $genrises = GoodsGenre::find()->orderBy(['value' => SORT_ASC])->groupBy('value')->all();
        $publishers = Goods::find()->where(['hide' => 'Ні'])->orderBy(['publisher' => SORT_ASC])->groupBy('publisher')->all();

        $query = Goods::find()->where(['hide' => 'Ні']);

        $this->actionFilterGoods($query);
        $this->actionSortGoods($query);

        $query->andFilterWhere(['or',
                ['like', 'title', $q],
                ['like', 'author', $q],
                ['like', 'keywords', $q],
                ['like','articul',$q]
            ]
        );

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $pages->pageSizeParam = false;
        $model = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'categories' => $categories,
            'genrises' => $genrises,
            'category' => null,
            'subcategory' => null,
            'model' => $model,
            'pages' => $pages,
            'publishers' => $publishers,
        ]);
    }

    public function actionCategory($id)
    {

        if (($category = Category::findOne(['url_key' => $id])) !== null) {
            $category_id = $category->id;

            $good_id = [];
            $goods = Goods::find()->where(['hide' => 'Ні', 'category_id' => $category_id])->all();
            foreach ($goods as $good) {
                array_push($good_id, $good->id);
            }

            $categories = Category::find()->orderBy(['title' => SORT_ASC])->all();
            $genrises = GoodsGenre::find()->where(['good_id' => array_unique($good_id)])->orderBy(['value' => SORT_ASC])->groupBy('value')->all();
            $publishers = Goods::find()->where(['hide' => 'Ні', 'category_id' => $category_id])->orderBy(['publisher' => SORT_ASC])->groupBy('publisher')->all();

            $query = Goods::find()->where(['hide' => 'Ні', 'category_id' => $category_id]);

            $this->actionFilterGoods($query);
            $this->actionSortGoods($query);

            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
            $pages->pageSizeParam = false;
            $model = $query
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            return $this->render('index', [
                'categories' => $categories,
                'genrises' => $genrises,
                'category' => $category,
                'subcategory' => null,
                'model' => $model,
                'pages' => $pages,
                'publishers' => $publishers,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function actionSubcategory($id)
    {

        if (($subcategory = Subcategory::findOne(['url_key' => $id])) !== null) {
            $subcategory_id = $subcategory->id;

            $good_id = [];
            $goods = Goods::find()->where(['hide' => 'Ні', 'subcategory_id' => $subcategory_id])->all();
            foreach ($goods as $good) {
                array_push($good_id, $good->id);
            }

            $categories = Category::find()->orderBy(['title' => SORT_ASC])->all();
            $genrises = GoodsGenre::find()->where(['good_id' => array_unique($good_id)])->orderBy(['value' => SORT_ASC])->groupBy('value')->all();
            $publishers = Goods::find()->where(['hide' => 'Ні', 'subcategory_id' => $subcategory_id])->orderBy(['publisher' => SORT_ASC])->groupBy('publisher')->all();

            $query = Goods::find()->where(['hide' => 'Ні', 'subcategory_id' => $subcategory_id]);

            $this->actionFilterGoods($query);
            $this->actionSortGoods($query);

            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
            $pages->pageSizeParam = false;
            $model = $query
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            return $this->render('index', [
                'categories' => $categories,
                'genrises' => $genrises,
                'category' => Category::findOne(['id' => $subcategory->category_id]),
                'subcategory' => $subcategory,
                'model' => $model,
                'pages' => $pages,
                'publishers' => $publishers,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function actionGood($id)
    {
        if (($model = Goods::findOne(['url_key' => $id, 'hide' => 'Ні'])) !== null) {
            $good_characteristics = GoodsCharacteristics::find()->where(['good_id' => $model->id])->orderBy(['id' => SORT_ASC])->all();
            $good_description = GoodsDescription::findOne(['good_id' => $model->id]);
            $good_images = GoodsImages::find()->where(['good_id' => $model->id])->orderBy(['id' => SORT_ASC])->all();

            return $this->render('good', [
                'category' => Category::findOne(['id' => $model->category_id]),
                'subcategory' => Subcategory::findOne(['id' => $model->subcategory_id]),
                'model' => $model,
                'good_characteristics' => $good_characteristics,
                'good_description' => $good_description,
                'good_images' => $good_images,
            ]);
        }

        throw new NotFoundHttpException('Запитувана сторінка не існує.');
    }

    public function actionSortGoods($query)
    {
        $sort = Yii::$app->request->get('sort');

        if ($sort) {
            if (mb_substr($sort, 0, 1) === "-") {
                $query->orderBy(['available' => SORT_ASC, str_replace('-', '', $sort) => SORT_DESC]);
            } else {
                $query->orderBy(['available' => SORT_ASC, str_replace('-', '', $sort) => SORT_ASC]);
            }
        } else {
            $query->orderBy(['available' => SORT_ASC, 'created_at' => SORT_DESC]);
        }

        return $query;
    }

    public function actionFilterGoods($query)
    {
        $genre = Yii::$app->request->get('genre');
        $publisher = Yii::$app->request->get('publisher');

        if ($genre) {
            $query->andFilterWhere(['like', 'genre', $genre]);
        }
        if ($publisher) {
            $query->andFilterWhere(['like', 'publisher', $publisher]);
        }

        return $query;
    }
}
