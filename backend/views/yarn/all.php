<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use common\models\Date;
use common\models\ProductYarn;


$this->title = 'All Yarns';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h2><?= Html::encode($this->title) ?></h2>

    <div class="action-panel">
        <ul class="list-inline">
            <li><?= Html::a('Add yarn', ['yarn/add'], ['class' => 'btn  btn-success']) ?></li>
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
    'emptyText' => '<tr><td colspan="3" class="text-muted text-center">List of yarns is empty or nothing was found.</td></tr>',

    'columns' => [
        [
            'label' => '',
            'format' => 'html',
            'content' => function($yarn) {
                return '<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="Action"><span class="glyphicon glyphicon-cog"></span></a>' . Dropdown::widget([
                    'items' => [
                        [
                            'label' => '<span class="glyphicon glyphicon-wrench"></span> Edit',
                            'url' => ['/yarn/edit', 'id' => $yarn->id]
                        ],

                        [
                            'label' => '<span class="text-danger" onclick=""><span class="glyphicon glyphicon-remove-circle"></span> Delete</span>',
                            'url' => ['/yarn/delete', 'id' => $yarn->id]
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
            'header' => 'Name',
            'attribute' => 'yarn_name',
            'format' => 'text',
            'options' => [
                'width' => 140
            ]
        ],
        [
            'header' => 'Cost',
            'attribute' => 'cost',
            'format' => 'text',
            'options' => [
                'width' => 80
            ]
        ],
        [
            'header' => 'Description',
            'attribute' => 'description',
            'format' => 'text'
        ],
    ],
]);

Pjax::end(); ?>