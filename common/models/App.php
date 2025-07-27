<?php
namespace common\models;


use Yii;

class App {

    public static function isPost() {
        return Yii::$app->request->isPost;
    }

    /**
     * Display alert messages to the user
     * @param $type string
     * @param $message string
     */
    public static function alert($type, $message) {
        Yii::$app->getSession()->setFlash($type, $message);
    }

    /**
     * Function catches get requests of the application
     * @param  string $get get value
     * @return $_GET[$get] (string)
     */
    public static function get($get) {
        return Yii::$app->request->get($get);
    }

    /**
     * Function gets $_POST requests
     * @param  [type] $post [description]
     * @return [type]       [description]
     */
    public static function post($post = null) {
        if($post !== null )
            return Yii::$app->request->post($post);
        else
            return Yii::$app->request->post();
    }
}