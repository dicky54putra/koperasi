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
class StokPenyesuaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stok_penyesuaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang', 'qty', 'tipe'], 'required'],
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
            'id_stok_penyesuaian_detail' => 'Id Stok Penyesuaian Detail',
            'id_barang' => 'Id Barang',
            'qty' => 'Qty',
            'tipe' => 'Tipe',
            'tanggal' => 'Tanggal',
            'keterangan' => 'Keterangan',
        ];
    }
}
