<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\App;
use common\models\ProductYarn;
use backend\models\ProductYarnAddForm;
use backend\models\ProductYarnEditForm;

/**
 * Yarn controller
 */
class YarnController extends Controller
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

        $query = ProductYarn::find()->where(['deleted' => 0])->orderBy('id DESC');
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
        $model = new ProductYarnAddForm();

        if( $model->load(App::post()) && $model->validate() ) {

            if( $model->add() ) {
                App::alert('success', 'Yarn was added.');
            } else {
                App::alert('danger', 'Error to add the yarn. Try again later.');
            }
            return $this->redirect(['yarn/all']);
        }

        return $this->render('add', [
            'model' => $model
        ]);
    }

    public function actionEdit() {

        $yarnId = App::get('id');

        /**
         * No ID specified or yarn does not exist
         */
        if( !$yarnId || !ProductYarn::exists($yarnId) )
            return $this->redirect(['yarn/all']);


        $model = new ProductYarnEditForm();
        $yarn = ProductYarn::findOne($yarnId);

        if( $model->load(App::post()) && $model->validate() ) {
            if( $model->update($yarnId) ) {
                App::alert('success', 'Yarn was updated.');
            } else {
                App::alert('danger', 'Error to update the yarn. This may mean that you have not changed anything. ');
            }
            return $this->redirect(['yarn/all']);
        }

        return $this->render('edit', [
            'model' => $model,
            'yarn' => $yarn
        ]);
    }

    public function actionDelete() {
        $yarnId = App::get('id');

        /**
         * No ID specified or yarn does not exist
         */
        if( !$yarnId || !ProductYarn::exists($yarnId) )
            return $this->redirect(['yarn/all']);

        $yarn = ProductYarn::findOne($yarnId);

        $yarn->deleted = 1; 

        if( $yarn->update() ) {
            App::alert('success', 'Yarn was deleted');
        } else {
            App::alert('danger', 'Error while deleting the yarn.');
        }

        return $this->redirect(['yarn/all']);
    }
}
