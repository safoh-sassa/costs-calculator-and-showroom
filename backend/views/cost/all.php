<?php
use yii\helpers\Html;
use yii\bootstrap\Dropdown;


$this->title = 'All Costs';
$this->params['breadcrumbs'][] = $this->title;
?>


<h2><?= Html::encode($this->title) ?></h2>

<div class="all-costs">
    <table class="table table-striped table-bordered" style="width: 400px">
        <thead>
            <tr>
                <th style="width: 30px"></th>
                <th style="width: 440px">Description</th>
                <th style="width: 120px">Value</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if( $costs ): ?>
                <?php foreach($costs as $cost): ?>
                    <tr>
                        <td>
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="Action">
                                    <span class="glyphicon glyphicon-cog"></span>
                                </a>
                                <ul id="w1" class="dropdown-menu">
                                    <li>
                                        <?= Html::a('<span class="glyphicon glyphicon-wrench"></span> Edit', ['cost/edit', 'id' => $cost->id]) ?>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td><?= Html::encode($cost->description) ?></td>
                        <td><?= Html::encode($cost->cost_amount) ?></td>
                        
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No costs found on the database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
