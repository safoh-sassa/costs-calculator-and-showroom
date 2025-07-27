<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\grid\GridView;
use common\models\Date;


$this->title = 'All Sales Representatives';
$this->params['breadcrumbs'][] = $this->title;
?>


    <h2><?= Html::encode($this->title) ?></h2>

    <div class="action-panel">
        <ul class="list-inline">
            <li><?= Html::a('Add Sales Representative', ['user/add'], ['class' => 'btn  btn-success']) ?></li>
    </div><br/>


<?php Pjax::begin();
echo GridView::widget([
    'id' => 'all-users',
    'dataProvider' => $dataProvider,
    'filterModel' => $filterModel,

    'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last',
        'maxButtonCount' => 5,
    ],
    'layout' => '<tr><td>{items}</td></tr><tr><td colspan="3">{pager}</td></tr>',
    'emptyText' => '<tr><td colspan="10" class="text-muted text-center">List of users is empty or nothing was found.</td></tr>',

    'columns' => [
        [
            'label' => '',
            'format' => 'html',
            'content' => function($user) {
                return '<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="Action"><span class="glyphicon glyphicon-cog"></span></a>' . Dropdown::widget([
                    'items' => [

                        [
                            'label' => '<span class="glyphicon glyphicon-wrench"></span> Edit',
                            'url' => ['/user/edit', 'id' => $user->id]
                        ],

                       
                        [
                            'label' => '<span class="text-danger" onclick=""><span class="glyphicon glyphicon-remove-circle"></span> Delete</span>',
                            'url' => ['/user/delete', 'id' => $user->id],
                            'options' => [
                                'onclick' => 'return confirm("Are you sure you want to delete '. Html::encode($user->first_name . ' ' . $user->last_name) .'?")'
                            ]
                        ],
                    ],
                    'encodeLabels' => false
                ]);
            }
        ],

        [
            'header' => 'ID',
            'attribute' => 'id'
        ],

        [
            'header' => 'Group',
            'attribute' => 'group_id',
            'format' => 'text',
            'content' => function($user) {
                return $user->group->group_name;
            }
        ],

        [
            'header' => 'First Name',
            'attribute' => 'first_name',
            'format' => 'text',
        ],
        
        [
            'header' => 'Last Name',
            'attribute' => 'last_name',
            'format' => 'text'
        ],
        
        [
            'header' => 'Username',
            'attribute' => 'username',
            'format' => 'text'
        ],
        [
            'header' => 'Email',
            'attribute' => 'email',
            'format' => 'text'
        ],
        [
            'header' => 'Date Created',
            'attribute' => 'created_at',
            'format' => 'text',
            'content' => function($user) {
                return Date::format('dmy', $user->created_at);
            }
        ]

    ],
]);

Pjax::end(); ?>