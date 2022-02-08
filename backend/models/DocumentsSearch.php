<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Documents;

/**
 * DocumentsSearch represents the model behind the search form of `app\models\Documents`.
 */
class DocumentsSearch extends Documents
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'status'], 'integer'],
            [['title', 'code', 'created_at', 'updated_at', 'filename', 'created_by', 'updated_by'], 'safe'],
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
        $query = Documents::find();

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

           
        $query->joinWith('createdBy','user');
        $query->leftJoin('user_profile', '"user_profile"."user_id" = "user"."id"');
               
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,  
            'type' => $this->type,
           // 'created_by' => $this->created_by,
            //'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'code', $this->code])
            ->andFilterWhere(['ilike', 'user_profile.lastname', $this->created_by])
            ->orFilterWhere(['ilike', 'user_profile.firstname', $this->created_by])
            ->andFilterWhere(['ilike', 'user_profile.lastname', $this->updated_by])
            ->orFilterWhere(['ilike', 'user_profile.firstname', $this->updated_by])
            ->andFilterWhere(['ilike', 'documents.created_at', $this->created_at])
            ->andFilterWhere(['ilike', 'documents.updated_at', $this->updated_at])
            ->andFilterWhere(['ilike', 'filename', $this->filename]);

        return $dataProvider;
    }
}
