<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use common\models\Date;
use common\models\Product;
use common\models\ProductType;

$this->title = 'All Products';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2><?= Html::encode($this->title) ?></h2>

    <div class="action-panel">
        <ul class="list-inline">
            <li><?= Html::a('Add product', ['product/add'], ['class' => 'btn  btn-success']) ?></li>
    </div><br/>

<?php Pjax::begin();
echo GridView::widget([
    'id' => 'all-products',
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,

    'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last',
        'maxButtonCount' => 5,
    ],
    'layout' => '<tr><td>{items}</td></tr><tr><td colspan="3">{pager}</td></tr>',
    'emptyText' => '<tr><td colspan="10" class="text-muted text-center">List of products is empty or nothing was found.</td></tr>',

    'columns' => [
        [
            'label' => '',
            'format' => 'html',
            'content' => function($product) {
                return '<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="Action"><span class="glyphicon glyphicon-cog"></span></a>' . Dropdown::widget([
                    'items' => [
                        [
                            'label' => '<span class="glyphicon glyphicon-wrench"></span> Edit',
                            'url' => ['/product/edit', 'id' => $product->id]
                        ],
                        Product::isAvailiable($product->id) ? [ 'label' => '<span class="glyphicon glyphicon-wrench"></span> Mark not availiable', 'url' => ['/product/not-availiable', 'id' => $product->id] ] : [ 'label' => '<span class="glyphicon glyphicon-wrench"></span> Mark availiable', 'url' => ['/product/availiable', 'id' => $product->id] ],
                        [
                            'label' => '<span class="text-danger" onclick=""><span class="glyphicon glyphicon-remove-circle"></span> Delete</span>',
                            'url' => ['/product/delete', 'id' => $product->id],
                            'options' => [
                                'onclick' => 'return confirm("Are you sure you want to delete '. Html::encode($product->product_name) .'?")'
                            ]
                        ],
                    ],
                    'encodeLabels' => false
                ]);
            }
        ],
        [
            'header' => 'View',
            'attribute' => 'availiable',
            'format' => 'text',
            'options' => [
                'width' => 50
            ],
            'content' => function($product) {
            if($product->availiable == 1)
                return "Yes";
            else {
            return "No";    
            }
            }
        ],        
        [
            'header' => 'Model',
            'attribute' => 'product_name',
            'format' => 'text',
            'options' => [
                'width' => 100
            ]
        ],
        [
            'header' => 'Type',
            'attribute' => 'type_id',
            'format' => 'text',
            'filter' => ProductType::getAllTypesAsArray(),
            'content' => function($product) {
                return $product->type->type_name;
            },
             'options' => [
                'width' => 130
            ]
        ],
        [
            'header' => 'Added By',
            'attribute' => 'user_id',
            'format' => 'text',
            'content' => function($product) {
                return $product->author->first_name . ' ' . $product->author->last_name;
            }
        ],
        [
            'header' => 'Composition',
            'attribute' => 'outer_yarn_id',
            'format' => 'text',
            'content' => function($product) {
                $html = '';
                $html = $product->outer_yarn_percent .'% ' . $product->outerYarn->yarn_name;
                if( $product->inner_yarn_id != 0 && $product->inner_yarn_percent != 0)
                    $html .= ' &amp; ' . $product->inner_yarn_percent .'% ' . $product->innerYarn->yarn_name;
                return $html;
            }
        ],
        [
            'header' => 'Weight (gr./doz.)',
            'attribute' => 'weight_id',
            'format' => 'text',
            'content' => function($product) {
                return $product->weight->weight_gram . ', Size:' . $product->weight->size .' ,'. $product->weight->description;
            }
        ],
        [
            'header' => 'Created Date',
            'attribute' => 'create_date',
            'format' => 'text',
            'content' => function($product) {
                return Date::format('dmy', $product->create_date);
            },
             'options' => [
                'width' => 120
            ]
        ],
        [
            'label' => 'Price/Doz',
            'format' => 'text',
            'content' => function($product) {
                $p = new Product();
                return "USD ".$p->getPrice($product->id);
            }
        ],
        [
            'header' => 'Picture',
            'attribute' => 'picture',
            'format' => 'html',
            'content' => function($product) {
                if(!$product->picture )
                    return 'No image';

                return Html::img(Product::getPicturePath($product->id), [
                    'alt' => $product->product_name,
                    'style' => 'max-width: 150px; max-height: 150px;'
                ]);
            }
        ],

    ],
]);
Pjax::end(); ?>