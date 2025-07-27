<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\CommissionShippingCost;


/**
 * User add form
 */
class UserAddForm extends Model
{
    public $group_id;
    public $first_name;
    public $last_name;
    public $username;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'group_id',
                    'first_name',
                    'last_name',
                    'username',
                    'email',
                    'password'
                ],
                'trim'
            ],

            ['email', 'email'],

            [
                [
                    'group_id',
                ],
                'integer',
                'message' => 'Please do not change source code for this input.'
            ],


            [
                [
                    'group_id',
                    'first_name',
                    'last_name',
                    'username',
                    'email',
                    'password'
                ],
                'required'
            ],

            ['first_name', 'checkCharactersField'],
            ['last_name', 'checkCharactersField']
           
        ];
    }

    public function checkCharactersField($attribute, $params) {
        if( !preg_match('~^[\p{L}\p{Z}]+$~u', $this->$attribute)  ) {
            $this->addError($attribute, 'Allowed only characters.');
        }
        // if( !preg_match('/\D{1,}/', $this->$attribute) ) {
        //     }
    }

    public function add() {
        $user = new User();



        $user->group_id =  $this->group_id;
        $user->first_name =  $this->first_name;
        $user->last_name =  $this->last_name;
        $user->username =  $this->username;
        $user->email =  $this->email;
        $user->password =  $user->setPassword($this->password);
        $user->created_at = time();
        $user->updated_at = time();

        $user->generateAuthKey();

        $userSaved = $user->save();

        $csc = new CommissionShippingCost();

        $csc->commission_value = 0;
        $csc->shipping_cost = 0;
        $csc->user_id = $user->id;

        $cscSave = $csc->save();

        return $userSaved && $cscSave;
    }
}
