<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use common\models\Date;

$this->title = 'All Price Lists';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h2><?= Html::encode($this->title) ?></h2>

    <div class="action-panel">
        <ul class="list-inline">
            <li><?= Html::a('New Price List', ['price-list/add'], ['class' => 'btn  btn-success']) ?></li>
    </div><br/>


<?php
echo GridView::widget([
    'id' => 'all-invoices',
    'dataProvider' => $dataProvider,

    'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last',
        'maxButtonCount' => 5,
    ],
    'layout' => '<tr><td>{items}</td></tr><tr><td colspan="3">{pager}</td></tr>',
    'emptyText' => '<tr><td colspan="10" class="text-muted text-center">List of invoices is empty or nothing was found.</td></tr>',

    'columns' => [
        [
            'label' => '',
            'format' => 'html',
            'content' => function($priceList) {
                return '<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="Action"><span class="glyphicon glyphicon-cog"></span></a>' . Dropdown::widget([
                    'items' => [
                        ['label' => '<span class="glyphicon glyphicon-eye-open"></span> View', 'url' => ['/price-list/view', 'id' => $priceList->id ]]
                    ],
                    'encodeLabels' => false
                ]);
            }
        ],
        [
            'header' => 'No.',
            'attribute' => 'id',
            'format' => 'text',
        ],
        [
            'header' => 'Customer',
            'attribute' => 'customer_id',
            'format' => 'text',
            'content' => function($priceList) {
                return Html::encode( $priceList->customer->customer_name );
            }
        ],
        [
            'header' => 'Sales Representative',
            'attribute' => 'user_id',
            'format' => 'text',
            'content' => function($priceList) {
                return Html::encode( $priceList->salesRepresentative->first_name . ' ' . $priceList->salesRepresentative->last_name );
            }
        ],
        [
            'header' => 'Commission Percent',
            'attribute' => 'commission_percent',
            'format' => 'text'
        ],
        [
            'header' => 'Date',
            'attribute' => 'created_at',
            'format' => 'text',
            'content' => function($priceList) {
                return Date::format('dmy', $priceList->created_at);
            }
        ]
    ],
]); ?>