<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\App;
use common\models\Cost;
use backend\models\CostEditForm;

/**
 * Cost controller
 */
class CostController extends Controller
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
                        'actions' => ['all', 'edit'],
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

    public function actionAll() {

        $costs = Cost::find()->orderBy('id ASC')->all();

        return $this->render('all', [
            'costs' => $costs
        ]);
    }



    public function actionEdit() {

        $costId = App::get('id');

        /**
         * No ID specified or cost does not exist
         */
        if( !$costId || !Cost::exists($costId) )
            return $this->redirect(['cost/all']);


        $model = new CostEditForm();
        $cost = Cost::findOne($costId);

        if( $model->load(App::post()) && $model->validate() ) {


            if( $model->update($costId) ) {
                App::alert('success', 'Value was updated.');
            } else {
                App::alert('danger', 'Error to update the value. This may mean that you have not changed anything. ');
            }
            return $this->redirect(['cost/all']);
        }

        return $this->render('edit', [
            'model' => $model,
            'cost' => $cost
        ]);
    }
}
