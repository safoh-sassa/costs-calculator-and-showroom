<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\App;
use common\models\Customer;
use common\models\CustomerSearchForm;
use common\models\CustomerAddForm;


/**
 * Customer controller
 */
class CustomerController extends Controller
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
                        'actions' => ['all', 'add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get']
                ],
            ],
        ];
    }

    public function actionAll() {
        $filterModel = new CustomerSearchForm();

        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);

        return $this->render('all', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionAdd() {
        $model = new CustomerAddForm();

        if( $model->load(App::post()) && $model->validate() ) {

            if( $model->add() ) {
                App::alert('success', 'Customer was added.');
            } else {
                App::alert('danger', 'Error to add the customer. Try again later.');
            }
            return $this->redirect(['customer/all']);
        }

        return $this->render('add', [
            'model' => $model
        ]);
    }

    
}
