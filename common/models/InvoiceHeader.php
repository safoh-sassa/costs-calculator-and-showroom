<?php
namespace common\models;

use yii\db\ActiveRecord;

class InvoiceHeader extends ActiveRecord {
    public static function tableName()
    {
        return 'invoicesheader';
    }

    public static function exists($invoiceHeaderId) {
        return self::find()->where(['id' => $invoiceHeaderId])->exists();
    }

    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getSalesRepresentative() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}