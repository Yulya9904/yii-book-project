<?php

namespace app\controllers;

use app\forms\BookForm;
use app\models\Book;
use app\services\BookService;
use app\services\SmsService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookController extends Controller
{
    public function __construct(
        $id,
        $module,
        protected BookService $bookService,
        protected SmsService $smsService,
        $config = [],
    )
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()->with('authors'),
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id)
    {
        $book = $this->findModel($id);
        return $this->render('view', [
            'book' => $book,
        ]);
    }

    public function actionCreate()
    {
        $form = new BookForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->bookService->create($form);
            Yii::$app->session->setFlash('success', 'Книга создана');
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate(int $id)
    {
        $book = $this->findModel($id);
        $form = new BookForm();
        $form->setAttributes($book->getAttributes());
        $form->id = $book->id;
        $form->authors = $book->authors;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->bookService->update($book, $form);
            Yii::$app->session->setFlash('success', 'Книга обновлена');
            return $this->redirect(['view', 'id' => $book->id]);
        }
        return $this->render('update', [
            'model' => $form,
            'book' => $book,
        ]);
    }

    public function actionDelete(int $id)
    {
        $book = $this->findModel($id);
        $book->delete();
        Yii::$app->session->setFlash('success', 'Книга удалена');
        return $this->redirect(['index']);
    }

    private function findModel(int $id): Book
    {
        $model = Book::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Книга не найдена');
        }
        return $model;
    }
}