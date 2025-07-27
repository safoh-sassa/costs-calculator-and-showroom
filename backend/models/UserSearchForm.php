<?php
namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class UserSearchForm extends Model {

    public $first_name;
    public $last_name;
    public $username;
    public $email;

    public function rules() {
        return [
            [['first_name', 'last_name', 'username', 'email'], 'safe']
        ];
    }


    public function search($params) {

        $query = User::find()->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $dataProvider->setSort([
            'attributes' => [

                'first_name' => [
                    'asc' => ['first_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC],
                    'label' => 'First Name',
                    'default' => SORT_ASC
                ],
                'last_name' => [
                    'asc' => ['last_name' => SORT_ASC],
                    'desc' => ['last_name' => SORT_DESC],
                    'label' => 'Last Name',
                    'default' => SORT_ASC
                ],
                'username' => [
                    'asc' => ['username' => SORT_ASC],
                    'desc' => ['username' => SORT_DESC],
                    'label' => 'Username',
                    'default' => SORT_ASC
                ],
                'email' => [
                    'asc' => ['email' => SORT_ASC],
                    'desc' => ['email' => SORT_DESC],
                    'label' => 'Email',
                    'default' => SORT_ASC
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere('first_name LIKE "%' . $this->first_name . '%"');
        $query->andWhere('last_name LIKE "%' . $this->last_name . '%"');
        $query->andWhere('username LIKE "%' . $this->username . '%"');
        $query->andWhere('email LIKE "%' . $this->email . '%"');

        return $dataProvider;
    }
}

?>