<?php
namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Product;

class ProductSearchForm extends Model {

    public $product_name;
    public $type_id;

    public function rules() {
        return [
            [['product_name', 'type_id'], 'safe']
        ];
    }


    public function search($params) {

        $query = Product::find()->where(['deleted' => 0]   )->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        $dataProvider->setSort([
            'attributes' => [

                'product_name' => [
                    'asc' => ['product_name' => SORT_ASC],
                    'desc' => ['product_name' => SORT_DESC],
                    'label' => 'Title',
                    'default' => SORT_ASC
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere('product_name LIKE "%' . $this->product_name . '%"');
        $query->andWhere('type_id LIKE "%' . $this->type_id . '%"');

        return $dataProvider;
    }
}

?>