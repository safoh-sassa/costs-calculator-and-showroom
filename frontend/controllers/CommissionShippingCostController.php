<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\App;
use common\models\CommissionShippingCost;
use common\models\CommissionShippingCostEditForm;

/**
 * Commission Shipping Cost controller
 */
class CommissionShippingCostController extends Controller
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
                        'actions' => ['edit'],
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



    public function actionEdit() {

        $userId = App::get('id');

        /**
         * No ID specified or cost does not exist
         */
        if( !$userId || !CommissionShippingCost::exists($userId) )
            return $this->redirect(['product/all']);


        $model = new CommissionShippingCostEditForm();
        $csc = CommissionShippingCost::getOne($userId);



        if( $model->load(App::post()) && $model->validate() ) {


            if( $model->update($userId) ) {
                App::alert('success', 'Commission and Shipping cost was updated.');
            } else {
                App::alert('danger', 'Error to update commission and shipping cost. This may mean that you have not changed anything. ');
            }
            return $this->redirect(['product/all']);
        }

        return $this->render('edit', [
            'model' => $model,
            'csc' => $csc
        ]);
    }
}
