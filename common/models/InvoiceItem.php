<?php
namespace common\models;

use yii\db\ActiveRecord;
use common\models\InvoiceHeader;
use common\models\Customer;

class InvoiceItem extends ActiveRecord {
    public static function tableName()
    {
        return 'invoicesitems';
    }


    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getHeader() {
        return $this->hasOne(InvoiceItem::className(), ['id' => 'invoice_header_id']);
    }

    public static function getItems($invoiceHeaderId) {
        return self::findAll(['invoice_header_id' => $invoiceHeaderId]);
    }

    public static function getTotalCommission($invoiceHeaderId) {
        $items = self::find()->where(['invoice_header_id' => $invoiceHeaderId])->all();
        $sum = 0;

        foreach ($items as $key => $item) {
            $sum += $item->quantity * $item->commission;
        }

        return $sum;

    }

    public static function getCustomerByHeaderId($invoiceHeaderId) {
        $customerId = InvoiceHeader::findOne($invoiceHeaderId)->customer_id; 

        return Customer::findOne($customerId);
    }
}