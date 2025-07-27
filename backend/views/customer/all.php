<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use common\models\Date;
use common\models\Customer;



$this->title = 'All Customers';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h2><?= Html::encode($this->title) ?></h2>

    <div class="action-panel">
        <ul class="list-inline">
            <li><?= Html::a('Add customer', ['customer/add'], ['class' => 'btn  btn-success']) ?></li>
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
    'emptyText' => '<tr><td colspan="8" class="text-muted text-center">List of customers is empty or nothing was found.</td></tr>',

    'columns' => [
        [
            'label' => '',
            'format' => 'html',
            'content' => function($customer) {
                return '<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="Action"><span class="glyphicon glyphicon-cog"></span></a>' . Dropdown::widget([
                    'items' => [
                        [
                            'label' => '<span class="glyphicon glyphicon-wrench"></span> Edit',
                            'url' => ['/customer/edit', 'id' => $customer->id]
                        ],
                        [
                        'label' => '<span class="text-danger" onclick=""><span class="glyphicon glyphicon-remove-circle"></span> Delete</span>',
                            
                            'url' => ['/customer/delete', 'id' => $customer->id]
                        ],
                    ],
                    'encodeLabels' => false
                ]);
            }
        ],
        [
            'header' => 'Name',
            'attribute' => 'customer_name',
            'format' => 'text'
        ],
        [
            'header' => 'Country',
            'attribute' => 'country',
            'format' => 'text',
        ],
        [
            'header' => 'City',
            'attribute' => 'city',
            'format' => 'text'
        ],
        [
            'header' => 'Address',
            'attribute' => 'address',
            'format' => 'text'
        ],
        [
            'header' => 'Phone',
            'attribute' => 'phone',
            'format' => 'text'
        ],
        [
            'header' => 'Email',
            'attribute' => 'email',
            'format' => 'text'
        ],
        [
            'header' => 'Created By',
            'attribute' => 'user_id',
            'format' => 'text',
            'content' => function($customer) {
                return $customer->user->first_name . ' ' . $customer->user->last_name;
            },
             'options' => [
                'width' => 110
            ]
        ],
        [
            'header' => 'Date',
            'attribute' => 'created_at',
            'format' => 'text',
            'content' => function($customer) {
                return Date::format('dmy', $customer->created_at);
            }
        ],
    ],
]);

Pjax::end(); ?>