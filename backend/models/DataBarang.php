<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_barang".
 *
 * @property int $id_barang
 * @property int $id_kategori
 * @property int $id_satuan
 * @property string $kode_barang
 * @property string $nama_barang
 * @property int $id_anggota
 * @property int $harga_jual
 * @property int $harga_beli
 * @property int $is_active
 */
class DataBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kategori', 'id_satuan', 'nama_barang', 'harga_jual', 'harga_beli', 'is_active'], 'required'],
            [['id_kategori', 'id_satuan', 'id_anggota', 'harga_jual', 'harga_beli', 'is_active'], 'integer'],
            [['kode_barang', 'nama_barang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_barang' => 'Id Barang',
            'id_kategori' => 'Id Kategori',
            'id_satuan' => 'Id Satuan',
            'kode_barang' => 'Kode Barang',
            'nama_barang' => 'Nama Barang',
            'id_anggota' => 'Id Anggota',
            'harga_jual' => 'Harga Jual',
            'harga_beli' => 'Harga Beli',
            'is_active' => 'Is Active',
        ];
    }

    public function getkategori_barang()
    {
        return $this->hasOne(KategoriBarang::className(), ['id_kategori' => 'id_kategori']);
    }

    public function getsatuan()
    {
        return $this->hasOne(DataSatuan::className(), ['id_satuan' => 'id_satuan']);
    }

    public function getanggota()
    {
        return $this->hasOne(AnggotaKoperasi::className(), ['id_anggota' => 'id_anggota']);
    }
}
