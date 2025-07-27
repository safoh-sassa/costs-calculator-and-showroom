<?php
namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

class CustomerSearchForm extends Model {

    public $customer_name; 
    public $country;
    public $city;
    public $address; 
    public $phone; 
    public $email;

    public function rules() {
        return [
            [
                [
                'customer_name', 
                'country',
                'city',
                'address', 
                'phone', 
                'email'
                ], 
            'safe']
        ];
    }


    public function search($params) {

        $query = Customer::find()->where(['deleted' => 0])->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere('customer_name LIKE "%' . $this->customer_name . '%"'); 
        $query->andWhere('country LIKE "%' . $this->country . '%"');
        $query->andWhere('city LIKE "%' . $this->city . '%"');
        $query->andWhere('address LIKE "%' . $this->address . '%"'); 
        $query->andWhere('phone LIKE "%' . $this->phone . '%"'); 
        $query->andWhere('email LIKE "%' . $this->email . '%"');

        return $dataProvider;
    }
}

?>