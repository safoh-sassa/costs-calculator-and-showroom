<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class CommissionShippingCost extends ActiveRecord {
    public static function tableName()
    {
        return 'commissions_and_shipping_costs';
    }

    public static function exists($userId) {
        return self::find()->where(['user_id' => $userId])->exists();
    }

    public static function getOne() {
        return self::findOne(['user_id' => User::getUserId()]);
    }

    public static function getCommissionPercent() {
        return self::getOne()->commission_value;
    }

    public static function getShippingCost() {
        return self::getOne()->shipping_cost;
    }

}