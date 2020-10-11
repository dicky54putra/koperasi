<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "stok_penyesuaian_detail".
 *
 * @property int $id_stok_penyesuaian_detail
 * @property int $id_stok_penyesuaian
 * @property int $id_barang
 * @property int $qty
 */
class StokPenyesuaianDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stok_penyesuaian_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok_penyesuaian', 'id_barang', 'qty'], 'required'],
            [['id_stok_penyesuaian', 'id_barang', 'qty'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok_penyesuaian_detail' => 'Id Stok Penyesuaian Detail',
            'id_stok_penyesuaian' => 'Id Stok Penyesuaian',
            'id_barang' => 'Id Barang',
            'qty' => 'Qty',
        ];
    }
}
