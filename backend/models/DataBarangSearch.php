<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataBarang;

/**
 * DataBarangSearch represents the model behind the search form of `backend\models\DataBarang`.
 */
class DataBarangSearch extends DataBarang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang', 'id_kategori', 'id_satuan', 'id_anggota', 'harga_jual', 'harga_beli', 'is_active'], 'integer'],
            [['kode_barang', 'nama_barang'], 'safe'],
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
        $query = DataBarang::find();

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
            'id_barang' => $this->id_barang,
            'id_kategori' => $this->id_kategori,
            'id_satuan' => $this->id_satuan,
            'id_anggota' => $this->id_anggota,
            'harga_jual' => $this->harga_jual,
            'harga_beli' => $this->harga_beli,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'kode_barang', $this->kode_barang])
            ->andFilterWhere(['like', 'nama_barang', $this->nama_barang]);

        return $dataProvider;
    }
}
