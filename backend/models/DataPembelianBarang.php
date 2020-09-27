<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_pembelian_barang".
 *
 * @property int $id_pembelian
 * @property string $tanggal_pembelian
 * @property int $id_anggota
 * @property string $no_faktur
 */
class DataPembelianBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_pembelian_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_pembelian'], 'required'],
            [['tanggal_pembelian'], 'safe'],
            [['id_anggota', 'grandtotal'], 'integer'],
            [['no_faktur'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pembelian' => 'Id Pembelian',
            'tanggal_pembelian' => 'Tanggal Pembelian',
            'id_anggota' => 'Id Anggota',
            'no_faktur' => 'No Faktur',
        ];
    }

    public function getAnggota()
    {
        return $this->hasOne(AnggotaKoperasi::className(), ["id_anggota"=>"id_anggota"]);
    }
}
