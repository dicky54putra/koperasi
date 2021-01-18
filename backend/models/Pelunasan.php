<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pelunasan".
 *
 * @property int $id_pelunasan
 * @property int $id_simpan_pinjam
 * @property string $tanggal
 * @property int $nominal
 * @property string $catatan
 */
class Pelunasan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pelunasan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_simpan_pinjam', 'tanggal', 'nominal', 'catatan'], 'required'],
            [['id_simpan_pinjam', 'nominal'], 'integer'],
            [['tanggal'], 'safe'],
            [['catatan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pelunasan' => 'Id Pelunasan',
            'id_simpan_pinjam' => 'Id Simpan Pinjam',
            'tanggal' => 'Tanggal',
            'nominal' => 'Nominal',
            'catatan' => 'Catatan',
        ];
    }
}
