<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\App;

/**
 * Report controller
 */
class ReportController extends Controller
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
                        'actions' => ['most', 'total', 'date-range'],
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

    public function actionMost() {

        $quantity = App::get('number');


        $products = Yii::$app->db->createCommand('SELECT `quantity`, `product_id`, sum(quantity) as total_quantity FROM `invoicesitems` GROUP BY `product_id` ORDER BY total_quantity DESC LIMIT ' . ((int)$quantity == '' ? 3 : $quantity))->queryAll();

        

        return $this->render('most', ['products' => $products]);
    }

    public function actionTotal() {
        $dateFrom = App::get('datefrom');
        $dateTo = App::get('dateto');
        $timeFrom = App::get('timefrom');
        $timeTo = App::get('timeto');


        if( $timeFrom && $timeTo ) {
            $dateFrom .= ' ' . $timeFrom;
            $dateTo .= ' ' . $timeTo;
        }

        $dateFrom = strtotime($dateFrom);
        $dateTo = strtotime($dateTo);


        if( $dateFrom && $dateTo ) {
            $products = Yii::$app->db->createCommand('SELECT `quantity`, `price`, `created_at`, sum(`quantity` * `price`) as total FROM `invoicesitems` WHERE `created_at` BETWEEN '. $dateFrom .' AND '. $dateTo .' GROUP BY `quantity`, `price` ORDER BY `quantity`')->queryAll();

            

        
            $sum = 0;
            foreach($products as $product) {
                $sum += $product['total'];
            }


            return $this->render('total', ['total' => $sum]);
        } 


        return $this->render('total');
    }

    public function actionDateRange() {
        $dateFrom = App::get('datefrom');
        $dateTo = App::get('dateto');
        $timeFrom = App::get('timefrom');
        $timeTo = App::get('timeto');
        $value = App::get('value');

        $IDarray = [];


        if( $timeFrom && $timeTo ) {
            $dateFrom .= ' ' . $timeFrom;
            $dateTo .= ' ' . $timeTo;
        }

        $dateFrom = strtotime($dateFrom);
        $dateTo = strtotime($dateTo);


        if( $dateFrom && $dateTo && $value ) {
            $customers = Yii::$app->db->createCommand('
                SELECT 
                    h.`customer_id`, 
                    i.`invoice_header_id`, 
                    i.`quantity`, 
                    i.`price`, 
                    i.`created_at`, 
                    SUM(i.`quantity` * i.`price`) as total 
                FROM 
                    `invoicesitems` as i 
                INNER JOIN 
                    `invoicesheader` as h ON i.`invoice_header_id` = h.`id` 
                WHERE 
                    i.`created_at` 
                BETWEEN 
                    '. $dateFrom .' AND '. $dateTo .' 
                GROUP BY 
                    h.`customer_id`
                HAVING 
                    total >= '. $value .' 
                ORDER BY 
                    total DESC')->queryAll();

           
            return $this->render('date-range', ['customers' => $customers]);
        } 


        return $this->render('date-range');
    }
}
