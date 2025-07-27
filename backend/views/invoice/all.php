<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use common\models\Date;
use common\models\InvoiceItem;


$this->title = 'All Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h2><?= Html::encode($this->title) ?></h2>

    <div class="action-panel">
        <ul class="list-inline">
            <li><?= Html::a('New invoice', ['invoice/add'], ['class' => 'btn  btn-success']) ?></li>
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
            'content' => function($invoice) {
                return '<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="Action"><span class="glyphicon glyphicon-cog"></span></a>' . Dropdown::widget([
                    'items' => [
                        ['label' => '<span class="glyphicon glyphicon-eye-open"></span> View', 'url' => ['/invoice/view', 'id' => $invoice->id ]],

                        [
                            'label' => '<span class="text-danger" onclick=""><span class="glyphicon glyphicon-remove-circle"></span> Delete</span>',
                            'url' => ['/invoice/delete', 'id' => $invoice->id],
                            'options' => [
                                'onclick' => 'return confirm("Are you sure you want to delete it?")'
                            ]
                        ],
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
            'content' => function($invoice) {
                return Html::encode( $invoice->customer->customer_name );
            }
        ],
        [
            'header' => 'Sales Representative',
            'attribute' => 'user_id',
            'format' => 'text',
            'content' => function($invoice) {
                return Html::encode( $invoice->salesRepresentative->first_name . ' ' . $invoice->salesRepresentative->last_name );
            }
        ],

        [
            'header' => 'Commission Percent',
            'attribute' => 'commission_percent',
            'format' => 'text'
        ],
                
        [
            'header' => 'Total Commission',
            'format' => 'text',
            'content' => function($invoice) {
                return InvoiceItem::getTotalCommission($invoice->id);
            }
        ],
        [
            'header' => 'Date',
            'attribute' => 'created_at',
            'format' => 'text',
            'content' => function($invoice) {
                return Date::format('dmy', $invoice->created_at);
            }
        ]
    ],
]); ?>