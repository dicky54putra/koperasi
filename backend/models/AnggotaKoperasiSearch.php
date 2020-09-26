<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AnggotaKoperasi;

/**
 * AnggotaKoperasiSearch represents the model behind the search form of `backend\models\AnggotaKoperasi`.
 */
class AnggotaKoperasiSearch extends AnggotaKoperasi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_anggota', 'id_jenis_anggota', 'id_pangkat', 'is_active'], 'integer'],
            [['kode_anggota', 'nama_anggota', 'alamat_anggota', 'kota', 'telp', 'npwp', 'tanggal_keanggotaan'], 'safe'],
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
        $query = AnggotaKoperasi::find();

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
            'id_anggota' => $this->id_anggota,
            'id_jenis_anggota' => $this->id_jenis_anggota,
            'id_pangkat' => $this->id_pangkat,
            'tanggal_keanggotaan' => $this->tanggal_keanggotaan,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'kode_anggota', $this->kode_anggota])
            ->andFilterWhere(['like', 'nama_anggota', $this->nama_anggota])
            ->andFilterWhere(['like', 'alamat_anggota', $this->alamat_anggota])
            ->andFilterWhere(['like', 'kota', $this->kota])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'npwp', $this->npwp]);

        return $dataProvider;
    }
}
