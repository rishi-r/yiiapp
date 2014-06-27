<?php

class HomeController extends Controller {

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    function init()
    {
        parent::init();
    }
    
    public function actionIndex() 
    {
        //echo Yii::app()->input->stripClean("fdgfdgfdg");die;
        $userObj = new Users();
        //$userObj->test();
        //echo $userObj->getUserEncryptedKey();
        $links2 = array(
                        '<i class="fa fa-fire"></i> Dummy' => array('list'),
                        'test',
                        );
        $this->bCrumbs($links2);
        $this->render('index');
    }
    
    public function actionDashboard() 
    {
        //echo Yii::app()->input->stripClean("fdgfdgfdg");die;
        $userObj = new Users();
        //$userObj->test();
        //echo $userObj->getUserEncryptedKey();
        
        $this->render('dashboard');
    }
    
    function actionTest()
    {
        $userObj = new Users();
        $list = CHtml::listData($userObj->model()->findAll(),'user_key', 'user_name');
        echo CHtml::dropDownList('users', 1, $list, array('empty' => '(Select a user'));
    }
    
    
    /**
    * Displays the contact page
    */
    public function actionContact()
    {
        $model=new ContactForm();
        if(isset($_POST['ContactForm']))
        {
                $model->attributes=$_POST['ContactForm'];
                if($model->validate())
                {
                        $name='=?UTF-8?B?'.base64_encode($model->name).'?=';
                        $subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
                        $headers="From: $name <{$model->email}>\r\n".
                                "Reply-To: {$model->email}\r\n".
                                "MIME-Version: 1.0\r\n".
                                "Content-Type: text/plain; charset=UTF-8";

                        mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
                        Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                        $this->refresh();
                }
        }
        $this->render('contact',array('model'=>$model));
    }
    
    
    /**
    * Function to Register New User
    */
    public function actionRegister()
    {
        $model = new RegistrationForm;
        $post = Yii::app()->request->getPost('RegistrationForm');
        $isvalidated = CActiveForm::validate($model);

        if(strlen($isvalidated) == 2)
        {	
            $isAccountCreated = $model->createAccount($post);
            echo json_encode(array(
                                "status" => "success",
                                "msg" => $isAccountCreated,
                            ));
            Yii::app()->end();
        }
        echo json_encode(array("status" => "error","msg" => $isvalidated));
        Yii::app()->end();
    }
    
    /**
    * This is the action to handle external exceptions.
    */
    public function actionError()
    {
            if($error=Yii::app()->errorHandler->error)
            {
                    if(Yii::app()->request->isAjaxRequest)
                            echo $error['message'];
                    else
                            $this->render('error', $error);
            }
    }
    
    public function actionLogout()
    {
        Yii::app()->user->logout();
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->homeUrl);
    }

}