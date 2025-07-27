<?php
namespace common\models;

use yii\db\ActiveRecord;

class PriceListItem extends ActiveRecord {
    public static function tableName()
    {
        return 'price_list_item';
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getHeader() {
        return $this->hasOne(InvoiceItem::className(), ['id' => 'price_list_header_id']);
    }

    public static function getItems($invoiceHeaderId) {
        return self::findAll(['price_list_header_id' => $invoiceHeaderId]);
    }

    public static function getTotalCommission($invoiceHeaderId) {
        $items = self::find()->where(['price_list_header_id' => $invoiceHeaderId])->all();
        $sum = 0;

        foreach ($items as $key => $item) {
            $sum += $item->quantity * $item->commission;
        }

        return $sum;

    }
}