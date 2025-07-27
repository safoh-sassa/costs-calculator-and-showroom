<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\ProductYarn;


/**
 * Product Yarn Edit form
 */
class ProductYarnEditForm extends Model
{
    public $yarn_name;
    public $cost; 
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
                    'yarn_name',
                    'cost',
                    'description'
                ],
                'trim'
            ],

            [
                [
                    'cost',
                ],
                'double',
                'message' => 'Please input numbers only.'
            ],


            [
                [
                    'yarn_name',
                    'cost'
                ],
                'required'
            ],
        ];
    }

    public function update($yarnId) {
        $yarn = ProductYarn::findone($yarnId);

        $yarn->yarn_name = $this->yarn_name;
        $yarn->cost = $this->cost;
        $yarn->description = $this->description;

        return $yarn->update();
    }




}
