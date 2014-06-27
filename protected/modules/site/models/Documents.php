<?php

class Documents extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{user_pdf_docs}}';
    }

    public function primaryKey() {
        return 'pdfdoc_id';
    }

    public function relations() {
        return array(
            'useroridoc' => array(self::BELONGS_TO, 'UserOriDocs', array('ori_dockey' => 'oridoc_key'))
        );
    }

    public function scopes() {
        return array(
            'recently' => array(
                'order' => 'created_at DESC',
                'limit' => 3,
            )
        );
    }

    function uploadDoc() {
        $postData = array();
        $postData['doc_name'] = Yii::app()->input->stripClean(Yii::app()->request->getPost('doc_name'));
        $postData['doc_desc'] = Yii::app()->input->stripClean(Yii::app()->request->getPost('doc_desc'));
        $postData['search_tags'] = Yii::app()->input->stripClean(Yii::app()->request->getPost('search_tags'));
        $postData['unique_key'] = Yii::app()->input->stripClean(Yii::app()->request->getPost('unique_key'));
        $postData['file'] = $_FILES['fileImage'];
        $docHelper = new DocHelper();
        return $docHelper->ProcessDoc($postData);
        //@todo Need to decide if we can send only one varialbe to two
        //list($oriDocName, $oridockey) = UserFileFunctions::uploadOrignalFile($_FILES['upl'], $postData);
        //DocumentsController::actionUplStep2();
        //DocumentsController::actionUplStep3();
    }
    
    
    public function convertBaseDocs($docKey=null)
    {
        $pdfdoc = PdfDocs::model()->find(array(
            'select' => '*',
            'condition' => 'oridoc_key = :oridoc_key',
            'params' => array(':oridoc_key'=>$docKey)
        ));
        $density =  144;
        $geometry = Yii::app()->params['image_geometry'];
        $command = "/usr/bin/convert -quality 20 -resize %s -gravity center -extent %s -density %s %s %s";
        $uploadPath =  Yii::app()->params['uploadPath'];
        
        if(isset($pdfdoc->pdfdoc_id))
        {
            for($ctr = 1; $ctr<=$pdfdoc->total_pages;$ctr++)
            {
                $docname =  DocHelper::getFileExtensionForSteps(null,$pdfdoc->converted_docname);
                $docname =  $docname."-".$ctr.".".Yii::app()->params['img_conversion_format'];
                $outPutPath = $uploadPath.Yii::app()->user->getId().DIRECTORY_SEPARATOR.Yii::app()->params['processed_doc'].DIRECTORY_SEPARATOR.$docname;
                $newcommand = sprintf($command,$geometry,$geometry,$density, $outPutPath,$outPutPath);
                exec($newcommand);
             }
             
             return true;
             
        }
        return false;
    }
}
