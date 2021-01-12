<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "data_pangkat".
 *
 * @property int $id_pangkat
 * @property string $nama_pangkat
 */
class DataPangkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_pangkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_pangkat'], 'required'],
            [['nama_pangkat'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pangkat' => 'Id Pangkat',
            'nama_pangkat' => 'Pangkat',
        ];
    }
}
