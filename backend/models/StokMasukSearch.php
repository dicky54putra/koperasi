<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StokMasuk;

/**
 * StokMasukSearch represents the model behind the search form of `backend\models\StokMasuk`.
 */
class StokMasukSearch extends StokMasuk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_masuk', 'id_barang', 'total_qty'], 'integer'],
            [['tanggal_masuk', 'keterangan'], 'safe'],
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
        $query = StokMasuk::find();

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
            'id_stok_masuk' => $this->id_stok_masuk,
            'id_barang' => $this->id_barang,
            'total_qty' => $this->total_qty,
            'tanggal_masuk' => $this->tanggal_masuk,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
