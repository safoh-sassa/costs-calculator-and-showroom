<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Cost extends ActiveRecord {
    public static function tableName()
    {
        return 'costs';
    }

    public static function exists($costId) {
        return self::find()->where(['id' => $costId])->exists();
    }

    public static function getOne($costType) {
        return self::findOne(['cost_type' => $costType]);
    }

    public static function getRubberCost() {
        return self::getOne('Rubber')->cost_amount;
    }

    public static function getPackingCost() {
        return self::getOne('Packing')->cost_amount;
    }

    public static function getOtherCost() {
        return self::getOne('Other')->cost_amount;
    }

    public static function getProfitPercentCost() {
        return self::getOne('Profit Percent')->cost_amount;
    }



    public static function getProductionCapacity() {
        return self::getOne('Production Capacity')->cost_amount;
    }

    public static function getSalariesCost() {
        return self::getOne('Salaries')->cost_amount;
    }

    public static function getPackingWeightCost() {
        return self::getOne('Packing Weight')->cost_amount;
    }


}