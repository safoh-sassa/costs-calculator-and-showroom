<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Cost;


/**
 * Costs edit form
 */
class CostEditForm extends Model
{
    public $cost_amount;


    /**
     * This is the rules for the input validation
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'cost_amount',
                ],
                'trim'
            ],

            [
                [
                    'cost_amount',
                ],
                'double',
                'message' => 'Please input numbers only.'
            ],


            [
                [
                    'cost_amount',
                ],
                'required'
            ],
        ];
    }

    public function update($costId) {
        $cost = Cost::findone($costId);

        $cost->cost_amount = $this->cost_amount;

        return $cost->update();
    }




}
