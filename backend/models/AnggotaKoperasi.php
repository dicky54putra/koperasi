<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "anggota_koperasi".
 *
 * @property int $id_anggota
 * @property string $kode_anggota
 * @property string $nama_anggota
 * @property string $alamat_anggota
 * @property string $kota
 * @property string $telp
 * @property string $npwp
 * @property int $id_jenis_anggota
 * @property int $id_pangkat
 * @property string $tanggal_keanggotaan
 * @property int $is_active
 */
class AnggotaKoperasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anggota_koperasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_anggota', 'alamat_anggota', 'kota', 'telp', 'id_jenis_anggota', 'tanggal_keanggotaan', 'is_active'], 'required'],
            [['id_jenis_anggota', 'id_pangkat', 'is_active'], 'integer'],
            [['tanggal_keanggotaan'], 'safe'],
            [['kode_anggota', 'nama_anggota', 'kota', 'telp', 'npwp'], 'string', 'max' => 225],
            [['alamat_anggota'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_anggota' => 'Id Anggota',
            'kode_anggota' => 'Kode Anggota',
            'nama_anggota' => 'Nama Anggota',
            'alamat_anggota' => 'Alamat Anggota',
            'kota' => 'Kota',
            'telp' => 'Telp',
            'npwp' => 'Npwp',
            'id_jenis_anggota' => 'Jenis Anggota',
            'id_pangkat' => 'Id Pangkat',
            'tanggal_keanggotaan' => 'Tanggal Keanggotaan',
            'is_active' => 'Is Active',
        ];
    }

    public function getpangkat()
    {
        return $this->hasOne(DataPangkat::className(), ['id_pangkat' => 'id_pangkat']);
    }
}
