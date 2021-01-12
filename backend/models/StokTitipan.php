<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stok_penyesuaian".
 *
 * @property int $id_stok_penyesuaian
 * @property string $tanggal
 * @property string $keterangan
 */
class StokTitipan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stok_titipan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang', 'qty'], 'required'],
            [['id_barang', 'qty'], 'integer'],
            [['tanggal', 'keterangan'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_titipan' => 'Id Stok Penyesuaian Detail',
            'id_barang' => 'Id Barang',
            'qty' => 'Qty',
            'tanggal' => 'Tanggal',
            'keterangan' => 'Keterangan',
        ];
    }
}
