<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CategoryMinistery;

/**
 * CategoryMinisterySearch represents the model behind the search form of `app\models\CategoryMinistery`.
 */
class CategoryMinisterySearch extends CategoryMinistery
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ministery_id', 'category_id', 'creator', 'modiefier'], 'integer'],
            [['created_date', 'modiefied_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = CategoryMinistery::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ministery_id' => $this->ministery_id,
            'category_id' => $this->category_id,
            'creator' => $this->creator,
            'created_date' => $this->created_date,
            'modiefier' => $this->modiefier,
            'modiefied_at' => $this->modiefied_at,
        ]);

        return $dataProvider;
    }
}
