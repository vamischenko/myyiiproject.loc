<?php

namespace backend\models;

use yii\base\Model;
use common\models\Publication;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class PublicationSearch extends Model
{
    public $id;
    public $title;
    public $created_at;
    public $status_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'status_id'], 'integer'],
            [['title', 'created_at', 'published_at', 'user_id'], 'safe'],
            [['title'], 'string'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->getDefaultQuery();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
                'attributes' => [
                    'title',
                    'status_id',
                    'created_at',
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addConditions($query);

        return $dataProvider;
    }

    /**
     * @param ActiveQuery $query
     * @return ActiveQuery
     */
    protected function addConditions(ActiveQuery $query)
    {
        $query->andFilterWhere(['~*', 'title', preg_quote($this->title)]);
        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
        ]);

        return $query;
    }

    /**
     * @return ActiveQuery
     */
    protected function getDefaultQuery()
    {
        return Publication::find();
    }
}