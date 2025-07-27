<?php
namespace common\models;

use Yii;
use common\models\CommissionShippingCost;
use yii\base\Model;
use \yii\helpers\Json;
use common\models\User;
use common\models\Product;
use common\models\InvoiceHeader;
use common\models\InvoiceItem;


/**
 * Invoice add form
 */
class InvoiceAddForm extends Model
{
    public $customer_id;
    public $product_id;
    public $quantity;
    public $products_json; // this is textarea


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'customer_id',
                    'product_id',
                    'quantity',
                    'products_json'
                ],
                'trim'
            ],

            ['product_id', function($attribute, $params) {
                if( !$this->products_json ) {
                    $this->addError($attribute, 'Please add at least one product.');
                }
            }],

            [
                [
                    'customer_id',
                    'product_id',
                ],
                'integer',
                'message' => 'Please do not change source code for this input.'
            ],


            [['quantity'], 'integer', 'message' => 'Quantity should be an integer values.'],

        ];
    }

    public function add() {
        $invoiceHeader = new InvoiceHeader();


        $invoiceHeader->customer_id = $this->customer_id;
        $invoiceHeader->user_id = User::getUserId();

        $invoiceHeader->commission_percent = CommissionShippingCost::getCommissionPercent();
        $invoiceHeader->created_at = time();

        $invoiceHeader->save();

        $this->addAllProducts($invoiceHeader->id);
    }

    function addAllProducts($invoiceHeaderId) {
        $product = new Product();
        $productsJson = Json::decode($this->products_json);

        foreach ($productsJson as $key => $p) {
            $p = (object)$p;

            $invoiceItem = new InvoiceItem();

            $invoiceItem->invoice_header_id = $invoiceHeaderId;
            $invoiceItem->product_id = $p->id;
            $invoiceItem->quantity = $p->quantity;
            $invoiceItem->price = $product->getPrice($p->id);
            $invoiceItem->commission = $product->getPrice($p->id, 'commission-value');
            $invoiceItem->created_at = time();

            $invoiceItem->save();
        }
    }
}
