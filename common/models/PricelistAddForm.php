<?php
namespace common\models;

use Yii;
use common\models\CommissionShippingCost;
use yii\base\Model;
use \yii\helpers\Json;
use common\models\User;
use common\models\Product;
use common\models\PriceListHeader;
use common\models\PriceListItem;


/**
 * Price list add form
 */
class PriceListAddForm extends Model
{
    public $customer_id;
    public $product_id;
    public $products_json;


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

        ];
    }

    public function add() {
        $priceListHeader = new PriceListHeader();
        $priceListHeader->customer_id = $this->customer_id;
        $priceListHeader->user_id = User::getUserId();
        $priceListHeader->commission_percent = CommissionShippingCost::getCommissionPercent();
        $priceListHeader->created_at = time();
        $priceListHeader->save();
        $this->addAllProducts($priceListHeader->id);
    }

    function addAllProducts($priceListHeaderId) {
        $product = new Product();
        $productsJson = Json::decode($this->products_json);

        foreach ($productsJson as $key => $p) {
            $p = (object)$p;
            $priceListItem = new PriceListItem();
            $priceListItem->price_list_header_id = $priceListHeaderId;
            $priceListItem->product_id = $p->id;
            $priceListItem->price = $product->getPrice($p->id);
            $priceListItem->commission = $product->getPrice($p->id, 'commission-value');
            $priceListItem->save();
        }
    }
}
