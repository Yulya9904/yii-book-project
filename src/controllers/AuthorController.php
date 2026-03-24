<?php

declare(strict_types=1);

namespace app\controllers;

use app\forms\AuthorForm;
use app\forms\AuthorSubscriptionForm;
use app\models\Author;
use app\repositories\AuthorRepository;
use app\services\AuthorService;
use app\services\AuthorSubscriptionService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AuthorController extends Controller
{
    public function __construct(
        $id,
        $module,
        protected readonly AuthorService $authorService,
        protected readonly AuthorRepository $authorRepository,
        protected readonly AuthorSubscriptionService $subscriptionService,
        $config = []
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
                        'actions' => ['top', 'subscribe'],
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

    public function actionTop($year = null)
    {
        $year = $year ?: date('Y');
        return $this->render('top', [
            'authors' => $this
                ->authorRepository
                ->getToAuthorsByYear((int)$year),
            'year' => $year,
        ]);
    }

    public function actionSubscribe($authorId)
    {
        $form = new AuthorSubscriptionForm();
        $form->author_id = $authorId;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if ($this->subscriptionService->subscribe($form)) {
                Yii::$app->session->setFlash('success', 'Вы подписаны');
                return $this->redirect(['index']);
            }
        }
        return $this->render('subscribe', [
            'model' => $form,
        ]);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Author::find(),
            'pagination' => ['pageSize' => 20],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new AuthorForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->authorService->create($form);
            Yii::$app->session->setFlash('success', 'Автор создан');
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate(int $id)
    {
        $author = $this->findModel($id);
        $form = new AuthorForm();
        $form->setAttributes($author->getAttributes());
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->authorService->update($author, $form);
            Yii::$app->session->setFlash('success', 'Автор обновлён');
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);
        if ($model->books) {
            Yii::$app->session->setFlash('danger', 'Нельзя удалить автора, у которого заполнены книги');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $model->delete();
        Yii::$app->session->setFlash('success', 'Книга удалена');
        return $this->redirect(['index']);
    }

    private function findModel(int $id): Author
    {
        $model = Author::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Автор не найден');
        }
        return $model;
    }
}