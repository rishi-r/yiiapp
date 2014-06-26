<?php

class DocumentsController extends Controller {

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public $uploader_js;
    public $uploader_css;
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
    
    public function actionUpload() 
    {
        $this->uploader_css = 1;
        $this->uploader_js = 1;
        $uploader_form = $this->renderPartial('/elements/image_upload_form',array('upload_action' => Yii::app()->createUrl('documents/ajaxupload')),true);
        CommonFunctions::loadJs('custom/uploadDoc');
        $uploader_script = $this->renderPartial('/elements/file_uploader',array(),true);
        $this->render('upload',array('uploader_form' => $uploader_form,'uploader_script' => $uploader_script));
    }
}