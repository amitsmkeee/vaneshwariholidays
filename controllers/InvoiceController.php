<?php

namespace app\controllers;
use Exception;
use Yii;
use app\models\Invoice;
use app\models\InvoiceItem;
use app\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'view', 'create', 'update', 'delete', 'download', 'add-section'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'update', 'delete', 'download', 'add-section'],
                            'roles' => ['@'],
                        ],
                    ],
                ],  
            ]
        );
    }

    /**
     * Lists all Invoice models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $queryInvoiceItems = InvoiceItem::find();
        $dataProviderInvoiceItems = new ActiveDataProvider([
            'query' => $queryInvoiceItems
         ]);
         $queryInvoiceItems->andFilterWhere([
            'invoiceId' => $id,
        ]);

        $invoiceItems = InvoiceItem::findAll(['invoiceId' => $id]);
        $totalAmount = 0;
        foreach ($invoiceItems as $invoiceItem) {
            $totalAmount += (float)$invoiceItem->amount;
        }


        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProviderInvoiceItems' => $dataProviderInvoiceItems,
            'totalAmount' => $totalAmount,
            'cgst' => $totalAmount * 0.05,
            'sgst' => $totalAmount * 0.05,
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Invoice();
        $sections = array();
        if (isset($_POST['Invoice'])) {
            $model->attributes = $_POST['Invoice'];
            if (isset($_POST['InvoiceItem'])) {
                $count = 0;
                foreach ($_POST['InvoiceItem'] as $value) {
                    $section = new InvoiceItem();
                    $section->attributes = $value;
                    $section->siNo = ++$count;
                    $sections[] = $section;
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Invoice item is missing');
                return $this->render('create', [
                    'model' => $model,
                    'sections' => $sections,
                ]);
            }

            try {
                $trans = Yii::$app->db->beginTransaction();
                $model->cBy =  Yii::$app->user->id;
                $totalAmount = 0;
                // $sectionMultiInsertCommand = new CDbMultiInsertCommand(new eeItem());
                foreach ($sections as $section) {
                    $section->invoiceId = $model->id;
                    $totalAmount += $section->amount;
                    // $section->libxml_set_external_entity_loader = $model->id;
                    $section->save(false);
                    // $sectionMultiInsertCommand->add($section, false);
                }

                $model->cgst = 0.05 * $totalAmount;
                $model->sgst = 0.05 * $totalAmount;
                $model->totalAmount = $totalAmount;
                $model->save(false);

                // $sectionMultiInsertCommand->execute();
                $trans->commit();

                Yii::$app->session->setFlash('success', "Invoice is successfully saved.");
                return $this->redirect(array('view', 'id' => $model->id));
            } catch (Exception $exp) {
                // oops, saving student or its related model failed. rollback and show the user an error.
                $trans->rollback();
                Yii::log(
                    "Error occurred while saving Invoice. Rolling back... " .
                        "Failure reason as reported in exception: " . $exp->getMessage(),
                    CLogger::LEVEL_ERROR,
                    __METHOD__
                );

                Yii::app()->user->setFlash('error', Yii::t("invoice-form", "Error while saving data:" . $exp->getMessage()));
            }
        } else {
            $invoiceDetails = Invoice::find()->orderBy(['invoiceId' => SORT_DESC])->one();
            $model->invoiceId = $invoiceDetails === null? 1 : $invoiceDetails->invoiceId + 1;
        }
        return $this->render('create', [
            'model' => $model,
            'sections' => $sections,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    
        if ($this->request->isPost && $model->load($this->request->post())) {
                $sectionToBeDeleted = array();
                if (isset($_POST['Invoice'])) {
                    $model->attributes=$_POST['Invoice'];
                    $validated = $model->validate();
                    $sections = InvoiceItem::findAll(['invoiceId' => $model->id]);
                    if (isset($_POST['InvoiceItem'])) {
                        $count = 0;
                        foreach ($_POST['InvoiceItem'] as $key => $value)
                        {
                            $section = isset($sections[$key]) ? $sections[$key] : new InvoiceItem();
                            $section->attributes = $value;
                            $section->siNo = ++$count;
                            $section->invoiceId = $model->id;
                            $validated = $validated && $section->validate();
                            $sections[$key] = $section;
                        }
                        foreach ($sections as $key => $section) {
                            if (!isset($_POST['InvoiceItem'][$key])) {
                                $sectionToBeDeleted[] = $section->si_no;
                            }
                        }
                        try{
                            $trans = Yii::$app->db->beginTransaction();
                            $model->cBy = Yii::$app->user->id;
                            $model->save(false);
                            if (count($sectionToBeDeleted) > 0) {
                                InvoiceItem::deleteAll(['siNo'=>$sectionToBeDeleted, 'invoiceId' => $model->id]);
                            }
                            $totalAmount = 0;
                            foreach ($sections as $section) {
                                $totalAmount += $section->amount;
                                $section->save(false);
                            }

                            $model->cgst = 0.05 * $totalAmount;
                            $model->sgst = 0.05 * $totalAmount;
                            $model->totalAmount = $totalAmount;
                            $model->save(false);
                            $trans->commit();
                            Yii::$app->session->setFlash('success', " Invoice is successfully saved.");
                            $this->redirect(array('view','id'=>$model->id));
                        } catch(Exception $exp) {
                            // oops, saving student or its related model failed. rollback and show the user an error.
                            $trans->rollback();
                            Yii::log("Error occurred while saving Question Paper. Rolling back... ".
                                "Failure reason as reported in exception: " . $exp->getMessage(),
                                CLogger::LEVEL_ERROR, __METHOD__);
                            
                            Yii::$app->session->setFlash('error',  "Error while saving data:".$exp->getMessage());
                        }
                    }
                    $this->redirect(array('view','id'=>$model->id));
                }
            } else{
                $sections = InvoiceItem::findAll(['invoiceId' => $id]);
                return $this->render('update', array('model' => $model, 'sections' => $sections));
            }
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->db->createCommand()->delete('invoiceItem', ['invoiceId' => $id])->execute();
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddSection($id = null)
    {
        $model = new InvoiceItem();
        $count = 0;
        if (isset($_POST['InvoiceItem'])) {
            $count = (int)(max(array_keys($_POST['InvoiceItem']))) + 1;
        }

        $model->invoiceId = $id;

        return $this->renderPartial('_addSection', array(
            'model' => $model,
            'count' => $count,
            'create' => true,
        ));
    }

    public function actionDownload($id)
    {
        $model = $this->findModel($id);
        $sections = InvoiceItem::findAll(['invoiceId' => $id]);

        return $this->render('download', [
            'model' => $model,
            'sections' => $sections
        ]);
    }
}
