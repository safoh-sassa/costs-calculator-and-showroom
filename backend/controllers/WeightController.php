<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\App;
use common\models\ProductWeight;
use backend\models\ProductWeightAddForm;
use backend\models\ProductWeightEditForm;

/**
 * Weight controller
 */
class WeightController extends Controller
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

        $query = ProductWeight::find()->where(['deleted' => 0])->orderBy('id DESC');
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

    public function actionAdd() {
        $model = new ProductWeightAddForm();

        if( $model->load(App::post()) && $model->validate() ) {

            if( $model->add() ) {
                App::alert('success', 'Weight was added.');
            } else {
                App::alert('danger', 'Error to add the weight. Try again later.');
            }
            return $this->redirect(['weight/all']);
        }

        return $this->render('add', [
            'model' => $model
        ]);
    }

    public function actionEdit() {

        $weightId = App::get('id');

        /**
         * No ID specified or yarn does not exist
         */
        if( !$weightId || !ProductWeight::exists($weightId) )
            return $this->redirect(['weight/all']);


        $model = new ProductWeightEditForm();
        $weight = ProductWeight::findOne($weightId);

        if( $model->load(App::post()) && $model->validate() ) {

            if( $model->update($weightId) ) {
                App::alert('success', 'Weight was updated.');
            } else {
                App::alert('danger', 'Error to update the weight. ');
            }
            return $this->redirect(['weight/all']);
        }

        return $this->render('edit', [
            'model' => $model,
            'weight' => $weight
        ]);
    }

    public function actionDelete() {
        $weightId = App::get('id');

        /**
         * No ID specified or weight does not exist
         */
        if( !$weightId || !ProductWeight::exists($weightId) )
            return $this->redirect(['weight/all']);

        $weight = ProductWeight::findOne($weightId);

        $weight->deleted = 1; 

        if( $weight->update() ) {
            App::alert('success', 'Weight was deleted');
        } else {
            App::alert('danger', 'Error while deleting the weight.');
        }

        return $this->redirect(['weight/all']);
    }
}
