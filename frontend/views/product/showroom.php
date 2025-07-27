<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use common\models\User;
use common\models\Date;
use common\models\Product;
use common\models\ProductType;


$this->title = 'Showroom';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h2><?= Html::encode($this->title) ?></h2>

<?php if( !User::isGuest() ): ?>
    <div class="action-panel">
        <ul class="list-inline">
            <li><?= Html::a('Add product', ['product/add'], ['class' => 'btn  btn-success']) ?></li>
    </div><br/>
<?php endif; ?>

<div>
<?= Html::a('<img src="img/price.gif"></img>', ['/site/contact'], 
[ 'style' => 'margin-bottom:10px']) ?>
</div>

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
            'header' => 'Picture',
            'attribute' => 'picture',
            'format' => 'html',
            'content' => function($product) {
                if(!$product->picture )
                    return 'No image';

                return Html::img(Product::getPicturePath($product->id), [
                    'alt' => $product->product_name,
                    'style' => 'max-width: 150px; max-height: 150px;',
                    'onclick' => 'window.open(this.src)',
                    'title'=> 'Click on the picture to enlarge'
                ]);
            },
             'options' => [
                'width' => 100
            ]
        ],

    ],
]);

Pjax::end(); ?>

<div>
<?= Html::a('<img src="img/price.gif"></img>', ['/site/contact'], 
[ 'style' => 'margin-bottom:10px']) ?>
</div>