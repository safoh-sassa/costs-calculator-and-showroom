<?php
namespace common\models;

use yii\db\ActiveRecord;

class ProductType extends ActiveRecord {
    public static function tableName()
    {
        return 'type';
    }

    /**
     * @param $productTypeId the ID of the weight
     * @return bool
     */
    public static function exists($productTypeId) {
        return self::find()->where(['id' => $productTypeId])->exists();
    }

    public static function getTypeName($typeId) {
        return self::findOne($typeId)->type_name;
    }

    public static function getAllTypesAsArray() {
    	$types = self::find()->all();

    	$_t = [];
      	foreach ($types as $key => $type) {
    		$_t[$type->id] = $type->type_name;
    	}


    	return $_t;
    }

}