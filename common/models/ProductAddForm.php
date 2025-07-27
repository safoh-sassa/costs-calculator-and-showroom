<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Product;
use common\models\User;


/**
 * Product add form
 */
class ProductAddForm extends Model
{
    public $model;
    public $type_id;
    public $outer_yarn_percent;
    public $outer_yarn_id;
    public $inner_yarn_percent;
    public $inner_yarn_id;
    public $weight_id;
    public $picture;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'model',
                    'type_id',
                    'outer_yarn_percent',
                    'outer_yarn_id',
                    'inner_yarn_percent',
                    'inner_yarn_id',
                    'weight_id'
                ],
                'trim'
            ],

            [
                [
                    'type_id',
                    'outer_yarn_id',
                    'inner_yarn_id',
                    'weight_id'
                ],
                'integer',
                'message' => 'Please do not change source code for this input.'
            ],

            [
                [
                    'outer_yarn_percent',
                    'inner_yarn_percent',
                ],
                'integer',
                'message' => 'Percentage should be an integer type. Example: "30" without %'
            ],

            [
                [
                    'model',
                    'type_id',
                    'outer_yarn_percent',
                    'weight_id'
                ],
                'required'
            ],

            ['outer_yarn_id', 'required', 'message' => 'Outer yarn cannot be blank.'],

            [['picture'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif, jpeg'],

        ];
    }

    public function add() {
        $model = new Product();

        $model->product_name = $this->model;
        $model->type_id = !$this->type_id ? 0 : $this->type_id;
        $model->outer_yarn_percent = $this->outer_yarn_percent;
        $model->outer_yarn_id = !$this->outer_yarn_id ? 0 : $this->outer_yarn_id;
        $model->inner_yarn_percent = !$this->inner_yarn_percent ? 0 : $this->inner_yarn_percent;
        $model->inner_yarn_id = !$this->inner_yarn_id ? 0 : $this->inner_yarn_id;
        $model->weight_id = !$this->weight_id ? 0 : $this->weight_id;
        $model->user_id = User::getUserId();
        $model->create_date = time();

        if( !empty($this->picture) ) {
            $model->picture = $this->uploadPicture();
        } else {
            $model->picture = '';
        }

        return $model->save();
    }

    public function uploadPicture() {
        $imgPath = '../../backend/web/uploads/' . (md5(time() . rand(1, 1000))) . '.' . $this->picture->extension;
        $this->picture->saveAs($imgPath);
        return $imgPath;
    }

}
