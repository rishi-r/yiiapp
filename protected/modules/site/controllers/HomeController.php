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
        $links2 = array('<i class="fa fa-fire"></i> Documents' => array('assignments/list'),
                                'Sign Document',
                        );
        $this->bCrumbs($links2);
        $this->render('index');
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