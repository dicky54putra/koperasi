<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "simpan_pinjam".
 *
 * @property int $id_simpan_pinjam
 * @property int $id_anggota
 * @property int $jenis
 * @property string $tanggal
 * @property int $status
 * @property string $keterangan
 */
class SimpanPinjam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'simpan_pinjam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_anggota', 'jenis', 'tanggal', 'status'], 'required'],
            [['id_anggota', 'jenis', 'status', 'nominal'], 'integer'],
            [['tanggal'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_simpan_pinjam' => 'Id Simpan Pinjam',
            'id_anggota' => 'Id Anggota',
            'jenis' => 'Jenis',
            'tanggal' => 'Tanggal',
            'status' => 'Status',
            'nominal' => 'Nominal',
            'keterangan' => 'Keterangan',
        ];
    }

    public function getAnggota()
    {
        return $this->hasOne(AnggotaKoperasi::className(), ['id_anggota' => 'id_anggota']);
    }
}
