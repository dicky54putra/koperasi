<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StokPenyesuaian;

/**
 * StokPenyesuaianSearch represents the model behind the search form of `backend\models\StokPenyesuaian`.
 */
class StokPenyesuaianSearch extends StokPenyesuaian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_penyesuaian'], 'integer'],
            [['tanggal', 'keterangan'], 'safe'],
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
        $query = StokPenyesuaian::find();

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
            'id_stok_penyesuaian' => $this->id_stok_penyesuaian,
            'tanggal' => $this->tanggal,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
