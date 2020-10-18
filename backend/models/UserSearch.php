<?php

namespace backend\models;

use yii\base\Model;
use common\models\User;
use yii\data\ActiveDataProvider;

class UserSearch extends Model
{
    public $id;
    public $username;
    public $name;
    public $surname;
    public $status_id;
    public $role_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'username', 'name', 'surname', 'status_id'], 'safe'],
            [['role_id'], 'integer']
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()
            ->select(['user.*'])
            ->andFilterWhere(['ilike', 'username', $this->username])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'surname', $this->surname])
            ->andFilterWhere(['role_id' => $this->role_id])
            ->groupBy(['user.id']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['username' => SORT_ASC],
                'attributes' => [
                    'username',
                    'status_id',
                    'role_id',
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['ilike', 'username', $this->username]);
        $query->andFilterWhere(['ilike', 'name', $this->name]);
        $query->andFilterWhere(['ilike', 'surname', $this->surname]);
        $query->andFilterWhere(['role_id' => $this->role_id]);
        $query->andFilterWhere([
            User::tableName() . '.id' => $this->id,
            'status_id' => $this->status_id,
        ]);

        return $dataProvider;
    }
}
