<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use backend\models\ProductEditForm;
use common\models\ProductSearchForm;
use common\models\ProductAddForm;
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
                        'actions' => ['all', 'edit', 'add', 'delete', 'availiable', 'not-availiable'],
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

    public function actionAvailiable() {
        $productId = App::get('id');

        /**
         * No ID specified or product does not exist
         */
        if( !$productId || !Product::exists($productId) )
            return $this->redirect(['product/all']);

        $product = Product::findOne($productId);

        $product->availiable = 1; 

        if( $product->update() !== false ) {
            App::alert('success', 'Product is marked as availiable.');
        } else {
            App::alert('danger', 'The product is already availiable.');
        }

        return $this->redirect(['product/all']);
    }

    public function actionNotAvailiable() {
        $productId = App::get('id');

        /**
         * No ID specified or product does not exist
         */
        if( !$productId || !Product::exists($productId) )
            return $this->redirect(['product/all']);

        $product = Product::findOne($productId);
        $product->availiable = 0; 

        if( $product->update() !== false ) {
            App::alert('success', 'Product is marked as not availiable.');
        } else {
            App::alert('danger', 'The product is already not availiable.');
        }
        return $this->redirect(['product/all']);
    }

    public function actionAll() {
        $filterModel = new ProductSearchForm();
        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);

        return $this->render('all', [
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

    public function actionEdit() {
        $productId = App::get('id');

        /**
         * No ID specified or product does not exist
         */
        if( !$productId || !Product::exists($productId) )
            return $this->redirect(['product/all']);

        $model = new ProductEditForm();
        $product = Product::findOne($productId);

        if( $model->load(App::post()) && $model->validate() ) {
            $model->picture = UploadedFile::getInstance($model, 'picture');

            if( $model->update($productId) ) {
                App::alert('success', 'Product was updated.');
            } else {
                App::alert('danger', 'Error to update the product. This may mean that you have not changed anything. ');
            }
            return $this->redirect(['product/all']);
        }

        return $this->render('edit', [
            'model' => $model,
            'product' => $product
        ]);
    }

    public function actionDelete() {
        $productId = App::get('id');

        /**
         * No ID specified or product does not exist
         */
        if( !$productId || !Product::exists($productId) )
            return $this->redirect(['product/all']);

        $product = Product::findOne($productId);
        $product->deleted = 1;
        
        //delete the picture file from uploads folder
        unlink(Product::getPicture($productId));

        if( $product->update() ) {
            App::alert('success', 'Product was deleted');
        } else {
            App::alert('danger', 'Error while deleting the product.');
        }
        return $this->redirect(['product/all']);
    }
}
