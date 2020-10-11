<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StokPenyesuaianDetail;

/**
 * StokPenyesuaianDetailSearch represents the model behind the search form of `backend\models\StokPenyesuaianDetail`.
 */
class StokPenyesuaianDetailSearch extends StokPenyesuaianDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_penyesuaian_detail', 'id_stok_penyesuaian', 'id_barang', 'qty'], 'integer'],
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
        $query = StokPenyesuaianDetail::find();

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
            'id_stok_penyesuaian_detail' => $this->id_stok_penyesuaian_detail,
            'id_stok_penyesuaian' => $this->id_stok_penyesuaian,
            'id_barang' => $this->id_barang,
            'qty' => $this->qty,
        ]);

        return $dataProvider;
    }
}
