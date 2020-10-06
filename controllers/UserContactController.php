<?php


namespace app\controllers;

use app\models\UserContact;
use app\models\UserContactForm;
use Intervention\Image\ImageManager;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;


class UserContactController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'view' => ['GET'],
                    'create' => ['GET', 'POST'],
                    'update' => ['GET', 'PUT', 'POST'],
                    'delete' => ['POST', 'DELETE'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $user_id = Yii::$app->user->getId();

        $query = (new UserContact())->getAllWithFilter($user_id, $request->get('user_name'),
            $request->get('phone'));

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('//contact/index', ['models' => $models, 'pages' => $pages]);
    }

    public function actionCreate()
    {
        $model = new UserContactForm();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstances($model, 'image');
            if ($model->add()) {
                return $this->redirect(Url::to(['user-contact/index']));
            }
        }

        return $this->render('//contact/create', ['model' => $model]);
    }

    public function actionView(int $id)
    {

    }

    public function actionUpdate(int $id)
    {

    }

    public function actionDelete(int $id)
    {

    }
}