<?php

namespace backend\controllers;

use backend\models\Passport;
use common\models\EduDirection;
use common\models\EduType;
use common\models\StepOne;
use common\models\StepThreeFour;
use common\models\StepThreeOne;
use common\models\StepThreeThree;
use common\models\StepThreeTwo;
use common\models\StepTwo;
use common\models\Student;
use common\models\StudentOferta;
use common\models\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Student models.
     *
     * @return string
     */
    public function actionIndex($id)
    {
        $eduType = $this->eduTypeFindModel($id);

        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams , $eduType);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'eduType' => $eduType
        ]);
    }

    public function actionChala()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->chala($this->request->queryParams);

        return $this->render('chala', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionContract()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->contract($this->request->queryParams);

        return $this->render('contract', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }


    /**
     * Displays a single Student model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Student();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_deleted = 1;
        $model->update(false);

        return $this->redirect(['index']);
    }


    public function actionInfo($id)
    {
        $student = $this->findModel($id);
        $user = $student->user;
        $model = new StepOne();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($user , $student);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('_form-step1' , [
            'model' => $model,
            'student' => $student,
        ]);
    }

    public function actionEduType($id)
    {
        $student = $this->findModel($id);
        $user = $student->user;
        $model = new StepTwo();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $result = $model->ikStep($user , $student);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax('_form-step2' , [
            'model' => $model,
            'student' => $student,
        ]);
    }


    public function actionDirection($id)
    {
        $student = $this->findModel($id);
        $user = $student->user;

        $action = '';
        if ($student->edu_type_id == 1) {
            $model = new StepThreeOne();
            $action = '_form-step3';
        } elseif ($student->edu_type_id == 2) {
            $model = new StepThreeTwo();
            $action = '_form-step32';
        } elseif ($student->edu_type_id == 3) {
            $model = new StepThreeThree();
            $action = '_form-step33';
        }  elseif ($student->edu_type_id == 4) {
            $model = new StepThreeFour();
            $action = '_form-step34';
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->edu_type_id = $student->edu_type_id;
                $result = $model->ikStep($user , $student);
                if ($result['is_ok']) {
                    $user->step = 5;
                    $user->update(false);
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view' , 'id' => $student->id]);
            }
        }

        return $this->renderAjax($action , [
            'model' => $model,
            'student' => $student,
        ]);
    }


    public function actionOfertaUpload($id)
    {
        $model = $this->ofertafindModel($id);

        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = StudentOferta::upload($model);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view', 'id' => $model->student_id]);
            }
        }

        return $this->renderAjax('oferta-upload', [
            'model' => $model,
        ]);
    }

    public function actionOfertaConfirm($id)
    {
        $model = $this->ofertafindModel($id);

        if ($this->request->isPost) {
            $post = $this->request->post();
            if ($model->load($post)) {
                $result = StudentOferta::upload($model);
                if ($result['is_ok']) {
                    \Yii::$app->session->setFlash('success');
                } else {
                    \Yii::$app->session->setFlash('error' , $result['errors']);
                }
                return $this->redirect(['view', 'id' => $model->student_id]);
            }
        }

        return $this->renderAjax('oferta-upload', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function ofertafindModel($id)
    {
        if (($model = StudentOferta::findOne(['id' => $id , 'is_deleted' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }

    protected function eduTypeFindModel($id)
    {
        if (($model = EduType::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page does not exist.'));
    }
}
