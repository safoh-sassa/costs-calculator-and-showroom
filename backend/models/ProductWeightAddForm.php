<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\ProductType;
use common\models\ProductWeight;


/**
 * Product Weight Add form
 */
class ProductWeightAddForm extends Model
{
    public $weight_gram;
    public $type_id;
    public $size;
    public $description;


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
                    'weight_gram',
                    'type_id',
                    'size',
                    'description'
                ],
                'trim'
            ],
            [
                [
                    'weight_gram',
                ],
                'double',
                'message' => 'Please enter numbers only for weight Gram.'
            ],

            [
                [
                    'weight_gram',
                    'type_id',
                    'size',
                    'description'
                ],
                'required'
            ],

            ['type_id', function($attribute, $params) {
                if( !ProductType::exists($this->$attribute) )
                    $this->addError($attribute, 'This type does not exist. Please do no change source code.');
            }]
        ];
    }


    public function add() {
        $weight = new ProductWeight();

        $weight->weight_gram = $this->weight_gram;
        $weight->type_id = $this->type_id;
        $weight->size = $this->size;
        $weight->description = $this->description;

        return $weight->insert();
    }




}
