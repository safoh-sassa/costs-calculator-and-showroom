<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use common\models\Date;
use common\models\Product;
use common\models\ProductType;


$this->title = 'All Weights';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h2><?= Html::encode($this->title) ?></h2>

    <div class="action-panel">
        <ul class="list-inline">
            <li><?= Html::a('Add Weight', ['weight/add'], ['class' => 'btn  btn-success']) ?></li>
    </div><br/>


<?php Pjax::begin();
echo GridView::widget([
    'id' => 'all-products',
    'dataProvider' => $dataProvider,

    'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last',
        'maxButtonCount' => 5,
    ],
    'layout' => '<tr><td>{items}</td></tr><tr><td colspan="3">{pager}</td></tr>',
    'emptyText' => '<tr><td colspan="5" class="text-muted text-center">List of weights is empty or nothing was found.</td></tr>',

    'columns' => [
        [
            'label' => '',
            'format' => 'html',
            'content' => function($weight) {
                return '<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="Action"><span class="glyphicon glyphicon-cog"></span></a>' . Dropdown::widget([
                    'items' => [
                        [
                            'label' => '<span class="glyphicon glyphicon-wrench"></span> Edit',
                            'url' => ['/weight/edit', 'id' => $weight->id]
                        ],

                        [
                            'label' => '<span class="text-danger" onclick=""><span class="glyphicon glyphicon-remove-circle"></span> Delete</span>',
                            'url' => ['/weight/delete', 'id' => $weight->id]
                        ],
                    ],
                    'encodeLabels' => false
                ]);
            },
            'options' => [
                'width' => 30
            ]
        ],
        [
            'header' => 'Grams',
            'attribute' => 'weight_gram',
            'format' => 'text',
            'options' => [
                'width' => 30
            ]
        ],
        [
            'header' => 'Type',
            'attribute' => 'type_id',
            'format' => 'text',
            'filter' => ProductType::getAllTypesAsArray(),
            'content' => function($weight) {
                return $weight->type->type_name;
            },
            'options' => [
                'width' => 90
            ]
        ],
        [
            'header' => 'Size',
            'attribute' => 'size',
            'format' => 'text',
            'options' => [
                'width' => 90
            ]
        ],
        [
            'header' => 'Description',
            'attribute' => 'description',
            'format' => 'text'
        ]
    ],
]);

Pjax::end(); ?>