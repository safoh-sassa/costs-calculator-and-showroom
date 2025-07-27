<?php
namespace common\models;

use yii\db\ActiveRecord;

class ProductWeight extends ActiveRecord {
    public static function tableName()
    {
        return 'weight';
    }

    public function getType() {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    /**
     * @param $productWeightId the ID of the weight
     * @return bool
     */
    public static function exists($productWeightId) {
        return self::find()->where(['id' => $productWeightId])->exists();
    }
}