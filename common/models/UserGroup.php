<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class UserGroup extends ActiveRecord {
    public static function tableName() {
        return 'user_group';
    }

    public static function getGroupSelectArray($type = 'array') {
        $_groups = self::find()->all();

        $groups = [];


        foreach ($_groups as $key => $group)
            $groups[$group->id] = $group->group_name;

        return $type == 'array' ? $groups : (object)$groups;
    }
}