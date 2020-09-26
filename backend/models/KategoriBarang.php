<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "kategori_barang".
 *
 * @property int $id_kategori
 * @property string $nama_kategori
 */
class KategoriBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kategori_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_kategori'], 'required'],
            [['nama_kategori'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kategori' => 'Id Kategori',
            'nama_kategori' => 'Nama Kategori',
        ];
    }
}
