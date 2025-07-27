<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Customer;


/**
 * Customer Add form
 */
class CustomerAddForm extends Model
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

    public function add() {
        $customer = new Customer();

        $customer->customer_name = $this->customer_name; 
        $customer->country = $this->country; 
        $customer->city = $this->city; 
        $customer->address = $this->address; 
        $customer->phone = $this->phone; 
        $customer->email = $this->email; 
        $customer->user_id = User::getUserId();
        $customer->created_at = time();

        return $customer->insert();
    }
}
