<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stok_keluar".
 *
 * @property int $id_stok_keluar
 * @property int $id_barang
 * @property int $qty
 * @property string $tanggal_keluar
 * @property string $keterangan
 */
class StokKeluar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stok_keluar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang'], 'required'],
            [['id_barang', 'total_qty'], 'integer'],
            [['tanggal_keluar'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_keluar' => 'Id Stok Keluar',
            'id_barang' => 'Id Barang',
            'total_qty' => 'Qty',
            'tanggal_keluar' => 'Tanggal Keluar',
            'keterangan' => 'Keterangan',
        ];
    }
}
