<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use backend\models\UserAddForm;
use backend\models\UserEditForm;
use backend\models\UserSearchForm;
use common\models\User;
use common\models\Product;
use common\models\App;

/**
 * Product controller
 */
class UserController extends Controller
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
//                    [
//                        'actions' => ['error'],
//                        'allow' => true,
//                    ],
                    [
                        'actions' => ['all', 'edit', 'add', 'delete'],
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
        $filterModel = new UserSearchForm();

        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);

        return $this->render('all', [
            'filterModel' => $filterModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionAdd() {
        $model = new UserAddForm();

        if( $model->load(App::post()) && $model->validate() ) {

            if( $model->add() ) {
                App::alert('success', 'User was added.');
            } else {
                App::alert('danger', 'Error to add the user. ');
            }
            return $this->redirect(['user/all']);
        }



        return $this->render('add', ['model' => $model]);
    }

    public function actionEdit() {

        $userId = App::get('id');

        /**
         * No ID specified or user does not exist
         */
        if( !$userId || !User::exists($userId) )
            return $this->redirect(['user/all']);


        $model = new UserEditForm();
        $user = User::findOne($userId);

        if( $model->load(App::post()) && $model->validate() ) {

            if( $model->update($userId) ) {
                App::alert('success', 'User was updated.');
            } else {
                App::alert('danger', 'Error to update the user. This may mean that you have not changed anything. ');
            }
            return $this->redirect(['user/all']);
        }

        return $this->render('edit', [
            'model' => $model,
            'user' => $user
        ]);
    }

    public function actionDelete() {
        $userId = App::get('id');

        /**
         * No ID specified or product does not exist
         */
        if( !$userId || !User::exists($userId) )
            return $this->redirect(['user/all']);


        if( Product::userHasProducts($userId) ) {
            App::alert('danger', 'Sorry, but you cannot delete user which has added products.');
            return $this->redirect(['user/all']);
        }

        if( User::deleteAllRelated($userId) ) {
            App::alert('success', 'User was deleted');
        } else {
            App::alert('danger', 'Error while deleting the user.');
        }

        return $this->redirect(['user/all']);
    }
}
