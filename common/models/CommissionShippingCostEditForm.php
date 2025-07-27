<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\CommissionShippingCost;


/**
 * CommissionShippingCost edit form
 */
class CommissionShippingCostEditForm extends Model
{
    public $commission;
    public $shipping;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'commission',
                    'shipping'
                ],
                'trim'
            ],


            [
                [
                    'commission',
                    'shipping'
                ],
                'double',
                'message' => 'Please input numbers only.'
            ],

            [
                [
                    'commission',
                    'shipping'
                ],
                'required'
            ],
        ];
    }

    public function update($userId) {
        $csc = CommissionShippingCost::getOne($userId);

        $csc->commission_value = $this->commission;
        $csc->shipping_cost = $this->shipping;

        return $csc->update();
    }

}
