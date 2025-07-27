<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Customer;


/**
 * Customer Edit form
 */
class CustomerEditForm extends Model
{
    public $customer_name;
    public $country;
    public $city;
    public $address;
    public $phone;
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [   
                    'customer_name',
                    'country',
                    'city',
                    'address',
                    'phone',
                    'email',
                ],
                'trim'
            ],

            ['email', 'email'],

            [
                [
                    'customer_name',
                    'country',
                    'city',
                    'address',
                    'phone',
                    'email',
                ],
                'required'
            ],
           
        ];
    }

    public function update($customerId) {
        $customer = Customer::findOne($customerId);

        $customer->customer_name = $this->customer_name; 
        $customer->country = $this->country; 
        $customer->city = $this->city; 
        $customer->address = $this->address; 
        $customer->phone = $this->phone; 
        $customer->email = $this->email; 

        return $customer->save();
    }
}
