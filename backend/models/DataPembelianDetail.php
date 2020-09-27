<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_pembelian_detail".
 *
 * @property int $id_pembelian_detail
 * @property int $id_pembelian
 * @property int $id_stok_masuk
 * @property int $id_barang
 * @property int $qty
 * @property int $diskon
 * @property int $harga_beli
 * @property int $ppn
 * @property int $total_beli
 */
class DataPembelianDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_pembelian_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pembelian', 'id_stok_masuk', 'id_barang', 'qty', 'diskon', 'harga_beli', 'ppn', 'total_beli'], 'required'],
            [['id_pembelian', 'id_stok_masuk', 'id_barang', 'qty', 'diskon', 'harga_beli', 'ppn', 'total_beli'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian_detail' => 'Id Pembelian Detail',
            'id_pembelian' => 'Id Pembelian',
            'id_stok_masuk' => 'Id Stok Masuk',
            'id_barang' => 'Id Barang',
            'qty' => 'Qty',
            'diskon' => 'Diskon',
            'harga_beli' => 'Harga Beli',
            'ppn' => 'Ppn',
            'total_beli' => 'Total Beli',
        ];
    }

    public function getBarang()
    {
        return $this->hasOne(DataBarang::className(), ["id_barang"=>"id_barang"]);
    }

    public function getStok_masuk()
    {
        return $this->hasOne(StokMasuk::className(), ["id_stok_masuk"=>"id_stok_masuk"]);
    }
}
