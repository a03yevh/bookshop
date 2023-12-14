<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Goods;

/**
 * GoodsSearch represents the model behind the search form of `app\models\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'subcategory_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'articul', 'url_key', 'publisher', 'genre', 'hide', 'available'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Goods::find();
        $sort = [
            'defaultOrder' => [
                'created_at' => SORT_DESC,
            ]
        ];

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'year' => $this->year,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'articul', $this->articul])
            ->andFilterWhere(['like', 'url_key', $this->url_key])
            ->andFilterWhere(['like', 'author', $this->url_key])
            ->andFilterWhere(['like', 'lang', $this->url_key])
            ->andFilterWhere(['like', 'publisher', $this->hide])
            ->andFilterWhere(['like', 'genre', $this->hide])
            ->andFilterWhere(['like', 'hide', $this->hide])
            ->andFilterWhere(['like', 'available', $this->available]);

        return $dataProvider;
    }
}
