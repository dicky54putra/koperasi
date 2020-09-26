<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_satuan".
 *
 * @property int $id_satuan
 * @property string $nama_satuan
 */
class DataSatuan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_satuan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_satuan'], 'required'],
            [['nama_satuan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_satuan' => 'Id Satuan',
            'nama_satuan' => 'Nama Satuan',
        ];
    }
}
