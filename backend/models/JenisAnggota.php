<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "jenis_anggota".
 *
 * @property int $id_jenis
 * @property string $nama_jenis
 */
class JenisAnggota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_anggota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_jenis'], 'required'],
            [['nama_jenis'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jenis' => 'Id Jenis',
            'nama_jenis' => 'Nama Jenis',
        ];
    }
}
