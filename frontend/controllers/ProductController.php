<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\ProductAddForm;
use frontend\models\ProductSearchForm;
use common\models\App;
use common\models\Product;

/**
 * Product controller
 */
class ProductController extends Controller
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
                        'actions' => ['showroom'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['all', 'showroom', 'add'],
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
        $filterModel = new ProductSearchForm();

        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);

        return $this->render('all', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionShowroom() {
        $filterModel = new ProductSearchForm();

        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);

        return $this->render('showroom', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionAdd() {
        $model = new ProductAddForm();

        if( $model->load(App::post()) && $model->validate() ) {

            $model->picture = UploadedFile::getInstance($model, 'picture');

            if( $model->add() ) {
                App::alert('success', 'Product was added.');
            } else {
                App::alert('danger', 'Error to add product. ');
            }
            return $this->redirect(['product/all']);
        }

        return $this->render('add', ['model' => $model]);
    }
}
