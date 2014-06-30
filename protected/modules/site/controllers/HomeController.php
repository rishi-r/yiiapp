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
    
    /**
    * Declares class-based actions.
    */
    public function actions()
    {
        return array(  
                // captcha action renders the CAPTCHA image displayed on the contact page
                'captcha'=>array(
                        'class'=>'CCaptchaAction',
                        'backColor'=>0xFFFFFF,
                ),

                'page'=>array(
                        'class'=>'CViewAction',
                ),
        );
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
        if(Yii::app()->user->isGuest)
            $this->render('index');
        else
        {
            //$login_form = $this->renderPartial('/elements/login_form',array(),true);
            $signup_form = $this->renderPartial('/elements/signup_form',array(),true);
            $this->render('site_index',array('signup_form' => $signup_form));
        }
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
        $this->breadcrumbs=array(                  
            );
        $model=new ContactForm;  
        if(isset($_POST['ContactForm']))
        {
            $model->attributes = $_POST['ContactForm'];
            if($model->validate())
            {
                $mailObj = new MailFunctions;
                $mailObj->auto = false;
                $mailObj->name = $model->name;
                $mailObj->subject = $model->subject;
                $mailObj->fromEmail = $model->email;
                $mailObj->body = $model->body;
                $mailObj->sendMail();
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
        if($error = Yii::app()->errorHandler->error)
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