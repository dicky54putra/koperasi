<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stok_masuk".
 *
 * @property int $id_stok_masuk
 * @property int $id_barang
 * @property int $total_qty
 * @property string $tanggal_masuk
 * @property string $keterangan
 */
class StokMasuk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stok_masuk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang', 'total_qty', 'tanggal_masuk', 'keterangan'], 'required'],
            [['id_barang', 'total_qty'], 'integer'],
            [['tanggal_masuk'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_masuk' => 'Id Stok Masuk',
            'id_barang' => 'Id Barang',
            'total_qty' => 'Total Qty',
            'tanggal_masuk' => 'Tanggal Masuk',
            'keterangan' => 'Keterangan',
        ];
    }
}
