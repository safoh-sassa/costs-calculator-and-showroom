<?php
namespace common\models;

use yii\db\ActiveRecord;

class PriceListHeader extends ActiveRecord {
    public static function tableName()
    {
        return 'price_list_header';
    }

    public static function exists($priceListHeader) {
        return self::find()->where(['id' => $priceListHeader])->exists();
    }

    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getSalesRepresentative() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}