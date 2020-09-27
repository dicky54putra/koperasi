<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_penjualan_barang".
 *
 * @property int $id_penjualan
 * @property string $tanggal_penjualan
 * @property int $id_anggota
 * @property string $jenis_pembayaran
 */
class DataPenjualanBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_penjualan_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_penjualan', 'id_anggota', 'jenis_pembayaran'], 'required'],
            [['tanggal_penjualan'], 'safe'],
            [['id_anggota', 'grandtotal'], 'integer'],
            [['jenis_pembayaran'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penjualan' => 'Id Penjualan',
            'tanggal_penjualan' => 'Tanggal Penjualan',
            'id_anggota' => 'Id Anggota',
            'jenis_pembayaran' => 'Status Pembayaran',
        ];
    }

    public function getAnggota()
    {
        return $this->hasOne(AnggotaKoperasi::className(), ["id_anggota" => "id_anggota"]);
    }
}
