<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataPenjualanDetail;

/**
 * DataPenjualanDetailSearch represents the model behind the search form of `backend\models\DataPenjualanDetail`.
 */
class DataPenjualanDetailSearch extends DataPenjualanDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan_detail', 'id_penjualan', 'id_stok_keluar', 'id_barang', 'qty', 'diskon', 'harga_jual', 'ppn', 'total_jual'], 'integer'],
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
        $query = DataPenjualanDetail::find();

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
            'id_penjualan_detail' => $this->id_penjualan_detail,
            'id_penjualan' => $this->id_penjualan,
            'id_stok_keluar' => $this->id_stok_keluar,
            'id_barang' => $this->id_barang,
            'qty' => $this->qty,
            'diskon' => $this->diskon,
            'harga_jual' => $this->harga_jual,
            'ppn' => $this->ppn,
            'total_jual' => $this->total_jual,
        ]);

        return $dataProvider;
    }
}
