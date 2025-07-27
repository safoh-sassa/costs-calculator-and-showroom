<?php
namespace frontend\controllers;

use Yii;
use \yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use common\models\App;
use common\models\Date;
use common\models\User;
use common\models\Product;
use common\models\ProductType;
use common\models\PriceListAddForm;
use common\models\PriceListHeader;
use common\models\PriceListItem;

/**
 * Invoice controller
 */
class PriceListController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'all',
                            'view',
                            'add',
                            'productinfo'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get'],
                ],
            ],
        ];
    }

    public function actionProductinfo() {
        $productId = Yii::$app->request->post('productId');
        $json = [];

        if( !$productId || !Product::exists($productId) ) {
            $json = [
                'type' => 'error',
                'message' => 'No ID specified or product does not exist'
            ];

            return Json::encode($json);
        }

        $p = new Product();
        $price = $p->getPrice($productId);
        $commission = $p->getPrice($productId, 'commission-value');

        $currentProduct = Product::findOne($productId);

        $json = [
            'type' => 'success',
            'price' => $price,
            'commission' => $commission,
            'imgUrl' => $currentProduct->picture
        ];

        return Json::encode($json);
    }

    public function actionAll() {


        $query = PriceListHeader::find()->where(['user_id' => User::getUserId()])->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('all', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView() {

        $PriceListHeaderId = App::get('id');

        if( !$PriceListHeaderId || !PriceListHeader::exists($PriceListHeaderId) ) {
            App::alert('danger', 'This invoice does not exist.');
            return $this->redirect(['price-list/all']);
        }
        ?>

        <style>
            body {
                font-size: 12pt;
                font-family: Arial, sans-serif;
            }
            table {
                border-collapse: collapse;
            }
            table thead tr th,
            table tbody tr td {
                padding: 10px;
            }
            table thead tr th {
                text-align: left;
                background-color: #eee;
            }

            table tbody tr#total td {
                text-align: right;
            }
        </style>
        <?php

        $priceListHeader = PriceListHeader::findOne($PriceListHeaderId);

        $sr = User::findIdentity($priceListHeader->user_id);

        $customerName = $priceListHeader->customer->customer_name;
        $dateOfIssue = Date::format('dmy', $priceListHeader->created_at);


        $items = PriceListItem::getItems($PriceListHeaderId);

        echo '<br><br><br><br><br>';
        echo '<u><h2>Price List</h2></u>';
        echo '<strong>Customer name</strong>: ' . $customerName . '<br>';
        echo '<strong>Price List No</strong>: ' . $PriceListHeaderId . '<br>';
        echo '<strong>Date of issue</strong>: ' . $dateOfIssue . '<br>';
        echo '<strong>Current date</strong>: ' . Date::format('dmy', time()). '<br>';
        echo '<strong>Issued by</strong>: ' . $sr->first_name . ' ' . $sr->last_name;
        echo '<br><br>';

        $html= null;


        $html = '<table><thead>';
        $html .= '<tr>';
        $html .= '<th>Product Name</th>';
        $html .= '<th>Type</th>';
        $html .= '<th>Size</th>';
        $html .= '<th>Composition</th>';
        $html .= '<th>Description</th>';
        $html .= '<th>Price/USD</th>';
        $html .='</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($items as $key => $item) {
            $html .= '<tr>';
            $html .= '<td>'. $item->product->product_name .'</td>';
            $html .= '<td>'. ProductType::getTypeName($item->product->type_id) .'</td>';
            $html .= '<td>'. $item->product->weight->size .'</td>';
            $html .= '<td>';
            $html .= $item->product->outer_yarn_percent . '% '. $item->product->outerYarn->yarn_name;
            if( $item->product->inner_yarn_id != 0 && $item->product->inner_yarn_percent != 0) {
                $html .=  ' & ' . $item->product->inner_yarn_percent . '% ' . $item->product->innerYarn->yarn_name;
            }
            $html .= '</td>';
            $html .= '<td>'. $item->product->weight->description .'</td>';
            $html .= '<td>'. $item->price .'</td>';
            $html .='</tr>';

        }
        $html .= '</tbody></table>';

        echo $html;
    }

    public function actionAdd() {
        $model = new PriceListAddForm();


        if( $model->load(App::post()) && $model->validate() ) {

            $model->add();
            App::alert('success', 'Invoice was added.');

            return $this->redirect(['price-list/all']);
        }



        return $this->render('add', ['model' => $model]);
    }
}
