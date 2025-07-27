<?php
namespace common\models;

use yii\db\ActiveRecord;

class ProductYarn extends ActiveRecord {
    public static function tableName()
    {
        return 'yarns';
    }

    /**
     * @param $productYarnId the ID of the yarn
     * @return bool
     */
    public static function exists($productYarnId) {
        return self::find()->where(['id' => $productYarnId])->exists();
    }
}