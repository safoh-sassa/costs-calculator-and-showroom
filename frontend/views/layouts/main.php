<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('img/logo.png'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if( User::isGuest() ){
        // $menuItems[] = ['label' => 'Showroom', 'url' => ['/product/showroom']];
        $menuItems[] =  ['label' => 'Contact', 'url' => ['/site/contact']];
        $menuItems[] =  ['label' => 'About', 'url' => ['/site/about']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    }

    if( !User::isGuest() ) {
        $menuItems[] = ['label' => 'Products', 'url' => ['/product/all']];
        $menuItems[] = ['label' => 'Customers', 'url' => ['/customer/all']];

        $menuItems[] = ['label' => 'Commission&Shipping Cost', 'url' => ['/commission-shipping-cost/edit', 'id' => User::getUserId()]];

        $menuItems[] = ['label' => 'Invoices', 'url' => ['/invoice/all']];

        $menuItems[] = ['label' => 'Price Lists', 'url' => ['/price-list/all']];

        if( User::isAdmin() ) {
            $link= Yii::$app->urlManagerbackEnd->baseUrl; 
            $port= $_SERVER['SERVER_PORT'];
            if ($port !='')
            {
            $link = str_replace('localhost', 'localhost'.':'.$port, $link); 
            }    
            $menuItems[] = ['label' => 'Admin panel', 'url' => $link];
        }

    }

    

    if ( !User::isGuest() ) {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
