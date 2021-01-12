<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Pelunasan;

/**
 * PelunasanSearch represents the model behind the search form of `backend\models\Pelunasan`.
 */
class PelunasanSearch extends Pelunasan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pelunasan', 'id_simpan_pinjam', 'nominal'], 'integer'],
            [['tanggal', 'catatan'], 'safe'],
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
        $query = Pelunasan::find();

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
            'id_pelunasan' => $this->id_pelunasan,
            'id_simpan_pinjam' => $this->id_simpan_pinjam,
            'tanggal' => $this->tanggal,
            'nominal' => $this->nominal,
        ]);

        $query->andFilterWhere(['like', 'catatan', $this->catatan]);

        return $dataProvider;
    }
}
