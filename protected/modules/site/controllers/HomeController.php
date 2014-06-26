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

}