<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;


/**
 * User edit form
 */
class UserEditForm extends Model
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
                ],
                'required'
            ],

        ];
    }

    public function update($userId) {
        $user = User::findOne($userId);

        $user->group_id =  $this->group_id;
        $user->first_name =  $this->first_name;
        $user->last_name =  $this->last_name;
        $user->username =  $this->username;
        $user->email =  $this->email;

        if( $this->password )
            $user->password =  $user->setPassword($this->password);

        $user->updated_at = time();

        return $user->update();
    }
}
