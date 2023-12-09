<?php 

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\ChangePasswordForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

class UserController extends Controller

{

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
                    'only' => ['change-password'],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

 

 public function actionChangePassword()

  {

    $model = new ChangePasswordForm();

    if(isset($_POST['ChangePasswordForm'])) {
        // print_r($_POST);
        // die;
    }
    
    if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
        Yii::$app->session->setFlash('success', "Password Successfully Changed.");
        return Yii::$app->response->redirect(Yii::$app->urlManager->createAbsoluteUrl(['user/change-password']));
    } else {
        Yii::$app->session->setFlash('error', "Password Changed failed");
    }

    $model->currentPassword = '';
    $model->newPassword = '';
    $model->newPasswordRepeat = '';
    // Mostrar formulario de cambio de contraseña.

    return $this->render('changePassword', [
        'model' => $model,
    ]);

  }

}


?>