<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\App;
use common\models\Customer;
use common\models\CustomerSearchForm;
use common\models\CustomerAddForm;
use backend\models\CustomerEditForm;

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
                        'actions' => ['all', 'add', 'edit', 'delete'],
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

    public function actionEdit() {

        $customerId = App::get('id');

        /**
         * No ID specified or customer does not exist
         */
        if( !$customerId || !Customer::exists($customerId) || Customer::isDeleted($customerId) )
            return $this->redirect(['customer/all']);


        $model = new CustomerEditForm();
        $customer = Customer::findOne($customerId);

        if( $model->load(App::post()) && $model->validate() ) {
            if( $model->update($customerId) ) {
                App::alert('success', 'Customer was updated.');
            } else {
                App::alert('danger', 'Error to update the customer. This may mean that you have not changed anything. ');
            }
            return $this->redirect(['customer/all']);
        }

        return $this->render('edit', [
            'model' => $model,
            'customer' => $customer
        ]);
    }

    public function actionDelete() {
        $customerId = App::get('id');

        /**
         * No ID specified or customer does not exist
         */
        if( !$customerId || !Customer::exists($customerId) || Customer::isDeleted($customerId) )
            return $this->redirect(['customer/all']);


        $customer = Customer::findOne($customerId);

        $customer->deleted = 1; 

        if( $customer->update() ) {
            App::alert('success', 'This user was successfully deleted.');
        } else {
            App::alert('danger', 'Error. This user is already delete or an unknown error happened.');
        }
    }
}
