<?php
namespace common\models;

use yii\db\ActiveRecord;

class Customer extends ActiveRecord {
    public static function tableName()
    {
        return 'customers';
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function isDeleted($userId) {
        return self::findOne($userId)->deleted == 1;
    } 

    /**
     * @param $customerId the ID of the product
     * @return bool
     */
    public static function exists($customerId) {
        return self::find()->where(['id' => $customerId])->exists();
    }

    public static function getCustomerSelectArray($type = 'array') {
        $_customers = self::find()->all();

        $customers = [];


        foreach ($_customers as $key => $t){
           $text= $t->customer_name . ' ,Country: '.$t->country . ', City: ' . $t->city . ', Address: '.  $t->address;
            $customers[$t->id]=$text;
        }
        return $type == 'array' ? $customers : (object)$customers;
    }
}