<?php
namespace backend\controllers;

use Yii;
use \yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use common\models\App;
use common\models\User;
use common\models\Date;
use common\models\Product;
use common\models\ProductType;
use common\models\InvoiceHeader;
use common\models\InvoiceAddForm;
use common\models\InvoiceItem;

/**
 * Invoice controller
 */
class InvoiceController extends Controller
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
                            'delete',
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

        $_product = Product::findOne($productId);

        $json = [
            'type' => 'success',
            'price' => $price,
            'commission' => $commission,
            'imgUrl' => $_product->picture
        ];

        return Json::encode($json);
    }

    public function actionAll() {


        $query = InvoiceHeader::find()->orderBy('id DESC');
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

        $invoiceHeaderId = App::get('id');

        if( !$invoiceHeaderId || !InvoiceHeader::exists($invoiceHeaderId) ) {
            App::alert('danger', 'This invoice does not exist.');
            return $this->redirect(['invoice/all']);
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


        $invoiceHeader = InvoiceHeader::findOne($invoiceHeaderId);

        $sr = User::findIdentity($invoiceHeader->user_id);


        $customerName = $invoiceHeader->customer->customer_name;
        $dateOfIssue = Date::format('dmy', $invoiceHeader->created_at);


        $items = InvoiceItem::getItems($invoiceHeaderId);

        echo '<br><br><br><br><br>';
        echo '<u><h2>Invoice</h2></u>';
        echo '<strong>Customer name</strong>: ' . $customerName . '<br>';
        echo '<strong>Invoice No</strong>: ' . $invoiceHeaderId . '<br>';
        echo '<strong>Date of issue</strong>: ' . $dateOfIssue . '<br>';
        echo '<strong>Current date</strong>: ' . Date::format('dmy', time()) . '<br>';
        echo '<strong>Issued by</strong>: ' . $sr->first_name . ' ' . $sr->last_name;

        echo '<br><br>';

        $totalSum = 0;


        $html = null;


        $html = '<table><thead>';
        $html .= '<tr>';
        $html .= '<th>Product Name</th>';
        $html .= '<th>Type</th>';
        $html .= '<th>Size</th>';
        $html .= '<th>Composition</th>';
        $html .= '<th>Description</th>';
        $html .= '<th>Quantity</th>';
        $html .= '<th>Price/USD</th>';
        $html .= '<th>Total</th>';
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
            $html .= '<td>'. $item->quantity .'</td>';
            $html .= '<td>'. $item->price .'</td>';
            $html .= '<td>'. $item->quantity * $item->price .'</td>';
            $html .='</tr>';

            $totalSum += $item->quantity * $item->price;
        }
        $html .= '<tr id="total"><td colspan="8" ><strong> Total invoice  USD '. $totalSum .'</td></strong></tr>';
        $html .= '</tbody></table>';

        echo $html;
    }

    public function actionAdd() {
        $model = new InvoiceAddForm();


        if( $model->load(App::post()) && $model->validate() ) {

            $model->add();
            App::alert('success', 'Invoice was added.');

            return $this->redirect(['invoice/all']);
        }



        return $this->render('add', ['model' => $model]);
    }


    public function actionDelete() {
        $invoiceHeaderId = App::get('id');

        /**
         * No ID specified or product does not exist
         */
        if( !$invoiceHeaderId || !InvoiceHeader::exists($invoiceHeaderId) )
            return $this->redirect(['invoice/all']);

        $invoiceHeader = InvoiceHeader::findOne($invoiceHeaderId);
        $invoiceItemDeletedNum = InvoiceItem::deleteAll(['invoice_header_id' => $invoiceHeaderId]);


        if( $invoiceHeader->delete() &&  $invoiceItemDeletedNum >= 1 ) {
            App::alert('success', 'Invoicewas deleted');
        } else {
            App::alert('danger', 'Error while deleting the invoice.');
        }

        return $this->redirect(['invoice/all']);
    }
}
