<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Product;


/**
 * Product edit form
 */
class ProductEditForm extends Model
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
     * This is the rules for the input validation
     *
     * @return array
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
                'message' => 'Please input numbers only. Example: "30" without %'
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

    public function update($productId) {
        $model = Product::findOne($productId);

        $model->product_name = $this->model;
        $model->type_id = !$this->type_id ? 0 : $this->type_id;
        $model->outer_yarn_percent = $this->outer_yarn_percent;
        $model->outer_yarn_id = !$this->outer_yarn_id ? 0 : $this->outer_yarn_id;
        $model->inner_yarn_percent = !$this->inner_yarn_percent ? 0 : $this->inner_yarn_percent;
        $model->inner_yarn_id = !$this->inner_yarn_id ? 0 : $this->inner_yarn_id;
        $model->weight_id = !$this->weight_id ? 0 : $this->weight_id;

        if( !empty($this->picture) && Product::hasPicture($productId) ) {
            $this->deletePicture($productId);
        }

        if( !empty($this->picture) )
            $model->picture = $this->uploadPicture();

        return $model->update();
    }

    public function uploadPicture() {
        $imgPath = 'uploads/' . (md5(time() . rand(1, 1000))) . '.' . $this->picture->extension;
        $this->picture->saveAs($imgPath);
        return $imgPath;
    }

    /**
     * Delete current picture of the product
     *
     * @param $productId
     * @return bool
     */
    private function deletePicture($productId) {
        return unlink(Product::getPicture($productId));
    }


}
