<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_penjualan_detail".
 *
 * @property int $id_penjualan_detail
 * @property int $id_penjualan
 * @property int $id_stok_keluar
 * @property int $id_barang
 * @property int $qty
 * @property int $diskon
 * @property int $harga_jual
 * @property int $ppn
 * @property int $total_jual
 */
class DataPenjualanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_penjualan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan', 'id_stok_keluar', 'id_barang', 'qty', 'diskon', 'harga_jual', 'ppn', 'total_jual'], 'required'],
            [['id_penjualan', 'id_stok_keluar', 'id_barang', 'qty', 'diskon', 'harga_jual', 'ppn', 'total_jual'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan_detail' => 'Id Penjualan Detail',
            'id_penjualan' => 'Penjualan',
            'id_stok_keluar' => 'Stok Keluar',
            'id_barang' => 'Barang',
            'qty' => 'Qty',
            'diskon' => 'Diskon',
            'harga_jual' => 'Harga Jual',
            'ppn' => 'Ppn',
            'total_jual' => 'Total Jual',
        ];
    }


    public function getBarang()
    {
        return $this->hasOne(DataBarang::className(), ["id_barang" => "id_barang"]);
    }

    public function getStok_keluar()
    {
        return $this->hasOne(StokKeluar::className(), ["id_stok_keluar" => "id_stok_keluar"]);
    }

    public function getPenjualan()
    {
        return $this->hasOne(DataPenjualanBarang::className(), ["id_penjualan" => "id_penjualan"]);
    }
}
