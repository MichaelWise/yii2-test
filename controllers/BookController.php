<?php

namespace app\controllers;

use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

use app\models\book\{Book, BookSeach};

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSeach();
        $dataProvider = $searchModel->search(Yii::$app->user->getId(), Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->getId() !== $model->getUserId()) {
            return $this->redirect('index');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if (Yii::$app->request->post() && $model = $this->createForm($model)) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->getId()]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->getId() !== $model->getUserId()) {
            return $this->redirect('index');
        }

        if (Yii::$app->request->post() && $this->createForm($model)->save()) {
            return $this->redirect(['view', 'id' => $model->getId()]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id) : Response
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->getId() == $model->getUserId()) {
            $model->delete();
        }

        return $this->redirect('index');
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Book
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param Book $model
     * @return Book
     */
    private function createForm(Book $model): Book
    {
        $oldImage = $model->getImage();
        $model->load(Yii::$app->request->post(), 'Book');

        if ($model->validate()) {
            $model->setUserId(Yii::$app->user->getId());
            /**
             * @var UploadedFile|null $image
             */
            $image = UploadedFile::getInstance($model, 'image');
            if ($image) {
                $model->saveImage($image);
            } else {
                $model->setImage($oldImage);
            }

        }
        return $model;
    }
}
