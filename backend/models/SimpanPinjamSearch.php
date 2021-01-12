<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SimpanPinjam;

/**
 * SimpanPinjamSearch represents the model behind the search form of `backend\models\SimpanPinjam`.
 */
class SimpanPinjamSearch extends SimpanPinjam
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_simpan_pinjam', 'id_anggota', 'jenis', 'status'], 'integer'],
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
        $query = SimpanPinjam::find();

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
            'id_simpan_pinjam' => $this->id_simpan_pinjam,
            'id_anggota' => $this->id_anggota,
            'jenis' => $this->jenis,
            'tanggal' => $this->tanggal,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
