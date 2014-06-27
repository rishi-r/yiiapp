<?php if ( ! defined('YII_PATH')) exit('No direct script access allowed');


class DocHelper extends CComponent
{
    /**
     * DocHelper::init()
     * 
     * @return
     */
    public function init()
    {
        parent::init();
    }
    
    function ProcessDoc($data)
    {
        $isDocValidated = $this->validateDocumentProp($data['file']);
        if (!$isDocValidated[0]) {
            //step:1 Prepare Directory Structure
            $this->createBaseDirectoryStructure();
            $uploaded = $this->uploadOrignalFile($data['file']);
            if(!$uploaded)
            {
                return array("status" => 'error', 'message' => "Error uploading file");
            }
            $saveReturn  = $this->saveDocfile($uploaded,$data['file']['name'][0],$data);
            if(!$saveReturn['status'])
            {
                return array("status" => 'error', 'message' => $saveReturn['message']);
            }
            
            $outPut = $this->processDocStep2();
            if(!$outPut)
            {
                return array("status" => 'error', 'message' => "Error in PDF conversion");
            }
            $outPut  = $this->processDocStep3();
            $docId = Yii::app()->user->getState('parent_dockey' . Yii::app()->user->getId());
            $ret_data = array(
                            "status" => "success",
                            'name' => substr($data['file']['name'][0],0,30),
                            'doc_id' => $docId,
                            'url' => 'javascript:void(0);',
                            'delete_url' => Yii::app()->createUrl('documents/deleteDoc/'.$docId),
                            'delete_type' => 'DELETE'
                        );
            return $ret_data;
        }
        return array("status" => 'error', 'message' => $isDocValidated[1]);
    }
    public function validateDocumentProp($file = null) {

        $returnData = array('0', 'validated'); // 0 for success and another for message;
        $allowedFileTypes = Yii::app()->params['allowed_files'];
        $docDefSize = Yii::app()->params['doc_size'];
        if (empty($allowedFileTypes) || empty($docDefSize) || is_null($file)) {
            Logs::addEvent(Yii::t('exceptions', 'INVALIDFILEPARAMS'));
            return $returnData = array('1', Yii::t('exceptions', 'INVALIDFILEPARAMS'));
        }
        $allowedFileTypes = explode(",", $allowedFileTypes);
        if (isset($file['name'][0]) && $file['error'][0] == 0) {
            $extension = pathinfo($file['name'][0], PATHINFO_EXTENSION);

            if (!in_array(strtolower($extension), $allowedFileTypes)) {

                $returnData = array('1', Yii::t('exceptions', 'INVALIDFILETYPE'));
                Logs::addEvent(Yii::t('exceptions', 'INVALIDFILETYPE'), Yii::app()->user->getId());
                return $returnData;
            }

            if ($docDefSize < $file['size'][0]) {

                $returnData = array('1', Yii::t('exceptions', 'INVALIDFILESIZE'));
                Logs::addEvent(Yii::t('exceptions', 'INVALIDFILESIZE'), Yii::app()->user->getId());
                return $returnData;
            }

            $successMsg = Yii::t('exceptions', 'FILEVALIDATEDSUCCESS') . 'File Details are: Size:' . $file['size'][0] . ' and File Type: ' . $extension;
            Logs::addEvent($successMsg, Yii::app()->user->getId(), 'sys-events', 'file-validated');
            return $returnData;
        }
        return $returnData;
    }
    
    public function uploadOrignalFile($file = null) {
        $uploadPath = Yii::app()->params['uploadPath'] . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['original_doc'] . DIRECTORY_SEPARATOR;

        $newFileName = substr(md5(uniqid(rand(), true)), 0, 16) . "." . pathinfo($file['name'][0], PATHINFO_EXTENSION);
        //step:2 Upload File to Directory

        if (!move_uploaded_file($file['tmp_name'][0], $uploadPath . $newFileName)) {
            Logs::addEvent(Yii::t('exceptions', 'FILEUPLOADERROR'), Yii::app()->user->getId(), 'File-upload');
            return false;
        }
        chmod($uploadPath . $newFileName, 0755);
        return $newFileName;
    }
    
    function saveDocfile($newFileName,$docOriName,$extraformdata = null)
    {
        //step:3 Save File info to DB
        $oriDocModel = new UserOriDocs();
        $oriDocKey = CommonFunctions::getEncryptedKey();
        $parent_dockey = 0;
        //Setting parameters for Document Merging Process
        $unkey = Yii::app()->user->getState('unkey' . Yii::app()->user->getId());
        if ($unkey != $extraformdata['unique_key']) {
            Yii::app()->user->setState('parent_docname' . Yii::app()->user->getId(), $newFileName);
            Yii::app()->user->setState('parent_dockey' . Yii::app()->user->getId(), $oriDocKey);
            Yii::app()->user->setState('parentPdfCount' . Yii::app()->user->getId(), 1);
            Yii::app()->user->setState('pdfStartCount' . Yii::app()->user->getId(), 1);
            Yii::app()->user->setState('unkey' . Yii::app()->user->getId(), $extraformdata['unique_key']);
            Yii::app()->user->setState('relativeFile' . Yii::app()->user->getId(), 0);
        } else {
            Yii::app()->user->setState('relativeFile' . Yii::app()->user->getId(), 1);
            $parent_dockey = Yii::app()->user->getState('parent_dockey' . Yii::app()->user->getId());
        }
        //Setting ends here 
        if (!is_null($extraformdata)) {
            $set_title = "";
            if (strlen(trim($extraformdata['doc_name'])) == 0)
            {
                $set_title = HtmlDataFunctions::replaceTitle($docOriName);
            }
            else
            {
                $set_title = HtmlDataFunctions::replaceTitle($extraformdata['doc_name']);
            }
            $oriDocModel->user_key = Yii::app()->user->getId();
            $oriDocModel->oridoc_key = $oriDocKey;
            $oriDocModel->oridoc_name = $set_title;
            $oriDocModel->oridoc_desc = $extraformdata['doc_desc'];
            $oriDocModel->oridoc_tags = $extraformdata['search_tags'];
            $oriDocModel->oridoc_filename = $newFileName;
            $oriDocModel->parent_dockey = $parent_dockey;
            $oriDocModel->system_details = CommonFunctions::getClientUserData();
            $oriDocModel->created_at = new CDbExpression('NOW()');
            $oriDocModel->updated_at = new CDbExpression('NOW()');
        }


        if (!$oriDocModel->save()) {
            return array("status" => 0, 'message' => "unable to save file data");
        }

        Logs::addEvent(Yii::t('exceptions', 'FILEUPLOADSUCCESS') . " (Original Document).", Yii::app()->user->getId(), 'File-upload', 'success');

        //Store original doc key in session for Storing in DB
        Yii::app()->user->setState('doc_key' . Yii::app()->user->getId(), $oriDocKey);
        Yii::app()->user->setState('doc_name' . Yii::app()->user->getId(), $newFileName);


        //Store Unique Doc Key to check if Next coming Doc needs merging or not
        return array("status" => 1, 'message' => "upload success", 'docKey' => $oriDocKey);
    }
    
    function processDocStep2() {
        $docName = Yii::app()->user->getState('doc_name'.Yii::app()->user->getId());
        if (is_null($docName)) {
            return false;
        }

        $uploadPath = Yii::app()->params['uploadPath'];
        $origPath = $uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['original_doc'];
        $outPutPath = $uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['pdf_conversion'];

        return $this->convert($origPath . DIRECTORY_SEPARATOR . $docName, $outPutPath, 'pdf', $docName);
    }

    function processDocStep3($docName = null) {
        $docName = Yii::app()->user->getState('doc_name'.Yii::app()->user->getId());
        if (is_null($docName)) {
            return false;
        }

        //check for Process 
        $isFileRelative = Yii::app()->user->getState('relativeFile' . Yii::app()->user->getId());

        //$imgFormat = 'jpg';
        //convert file extension to .jpg/.jpeg
        $sourceDocName = $this->getFileExtensionForSteps('pdf', $docName);
        $destinationDocName = $docName;
        if ($isFileRelative) {
            $destinationDocName = Yii::app()->user->getState('parent_docname' . Yii::app()->user->getId());
        }
        $outputDocName = $this->getFileExtensionForSteps(null, $destinationDocName);

        $uploadPath = Yii::app()->params['uploadPath'];
        $origPath = $uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['pdf_conversion'];
        $outPutPath = $uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['processed_doc'];

        $output = $this->convertToImage($origPath . DIRECTORY_SEPARATOR . $sourceDocName, $outPutPath . DIRECTORY_SEPARATOR . $outputDocName, $docName, $isFileRelative, $destinationDocName, $outPutPath);

        return $output;
    }

    /**
     * Prepare the User directory Structure ...
     */
    function createBaseDirectoryStructure($userKey = null) {
        $uploadPath = Yii::app()->params['uploadPath'];

        //--make Directory Structure --//
        @mkdir($uploadPath . Yii::app()->user->getId(), 0777);

        @mkdir($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['original_doc'], 0777);

        @mkdir($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['pdf_conversion'], 0777);

        @mkdir($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['processed_doc'], 0777);

        @mkdir($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['audits'], 0777);

        @mkdir($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['sign_folder'], 0777, true);
        //--make Proper Rights --//
        @chmod($uploadPath . Yii::app()->user->getId(), 0777);

        @chmod($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['original_doc'], 0777);

        @chmod($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['pdf_conversion'], 0777);

        @chmod($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['processed_doc'], 0777);

        @chmod($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['audits'], 0777);

        @chmod($uploadPath . Yii::app()->user->getId() . DIRECTORY_SEPARATOR . Yii::app()->params['sign_folder'], 0777);

        return true;
    }

    /**
     * Basic converter method
     * 
     * @param string $originFilePath Origin File Path
     * @param string $toFormat       Format to export To
     * @param string $outputDirPath  Output directory path
     */
     function convert($originFilePath, $outputDirPath, $toFormat, $docName = null) {

        $tmpFilename = explode(".", $docName);
        $ext = array_pop($tmpFilename);
        $docAndRanges = array();

        if ($ext != 'pdf') {
            $output = null;
            //@todo unoconv environment variable path needs to be decided
            $command = '/usr/bin/unoconv -f %s --output %s %s';
            $command = sprintf($command, $toFormat, $outputDirPath, $originFilePath);
            
            exec($command, $output);
        } else {
            copy($originFilePath, $outputDirPath . DIRECTORY_SEPARATOR . $docName);
        }

        if (!is_null($docName)) {
            $docName = $this->getFileExtensionForSteps('pdf', $docName);
            
            if(ISTESTSITE == true)
            {
                $output2 = null;
                $waterMarkCommand = "/usr/bin/convert %s -pointsize 120 -fill rgba\(102,102,102,0.4\) -gravity center -annotate -50x-40+0+0 'eSignly Demo' %s";
                $waterMarkCommand = sprintf($waterMarkCommand, $outputDirPath . DIRECTORY_SEPARATOR . $docName,$outputDirPath. DIRECTORY_SEPARATOR . $docName);
                
                exec($waterMarkCommand, $output2);
            }
            $output = null;
            //get the page count to store in DB

            $command = "/usr/bin/pdfinfo %s | grep Pages: | awk '{print $2}'";
            $command = sprintf($command, $outputDirPath . DIRECTORY_SEPARATOR . $docName);
            //$command .= ' >> /opt/lampp/htdocs/esignpro/pdfconversionlogs.txt';
            exec($command, $output);
            $totPdfCount = reset($output);

            $nextStartIndexForImage = 1;
            $isFileRelative = Yii::app()->user->getState("relativeFile" . Yii::app()->user->getId());
            
            if ($isFileRelative) {
                $docAndRanges = json_decode(Yii::app()->user->getState('docRanges' . Yii::app()->user->getId()), true);
                
                $parentPdfCount = Yii::app()->user->getState('parentPdfCount' . Yii::app()->user->getId());
                $pdfStartCount = $parentPdfCount + 1;

                Yii::app()->user->setState('pdfStartCount' . Yii::app()->user->getId(), $pdfStartCount);
            
                $endPageCount = $totPdfCount + $pdfStartCount - 1;
                @array_push($docAndRanges, $pdfStartCount . "&" . $endPageCount);
                $totPdfCount = $totPdfCount + $parentPdfCount;
            } else {
                //prepare Documents and Its Ranges for Sortring
                array_push($docAndRanges, "1&" . $totPdfCount);
            }

            Yii::app()->user->setState("parentPdfCount" . Yii::app()->user->getId(), $totPdfCount);
            Yii::app()->user->setState('docRanges' . Yii::app()->user->getId(), json_encode($docAndRanges));

            //Save Records to table//
            if (!$this->insertRecordsToPdfTable($totPdfCount, $isFileRelative)) {
                return false;
            }
            return true;
        }

        return false;
    }
    
    /**
     * Function to convert Docs to Images ...
     * @param string $originFilePath
     * @param string $outputDirPath
     * @param string $oridocname original Document Name 
     * @param integer $isRelativeFile 
     * @param string $parentDocName Parent Document Name
     * @return string $output
     */
     function convertToImage($originFilePath, $outputDirPath, $oridocname = null, $isRelativeFile = 0, $parentDocName = null, $outputPath = '') {

        $uploadPath = Yii::app()->params['uploadPath'];

        $newFileName = null;
        //prepare New File Name

        $imageCounter = Yii::app()->user->getState('pdfStartCount' . Yii::app()->user->getId());
        $totalPages = 1 + (Yii::app()->user->getState('parentPdfCount' . Yii::app()->user->getId()) - $imageCounter);

        if (!$isRelativeFile) {
            $docName = $this->getFileExtensionForSteps('png', $oridocname);
            $tmpName = explode(".", $docName);
            $ext = array_pop($tmpName);
            $newFileName = $tmpName[0] . "-1." . $ext;
        } else {
            $docName = $this->getFileExtensionForSteps('png', $parentDocName);

            $tmpName = explode(".", $docName);
            $ext = array_pop($tmpName);
            $newFileName = $tmpName[0] . "-" . $imageCounter . "." . $ext;
        }

        //----//
        $output = null;
        $geometry = Yii::app()->params['image_geometry'];

        $density = 144;
        //@todo convert environment variable path needs to be decided
        //$command = "/usr/bin/convert -quality 100 -resize %s -gravity center -extent %s  -verbose -density %s -colorspace RGB %s  +adjoin -scene %s %s";
        //$command = sprintf($command, $geometry."^",$geometry,$density, $originFilePath,$imageCounter,$outputDirPath);

        $command = "/usr/bin/gs -dNOPAUSE -dTextAlphaBits=4 -dGraphicsAlphaBits=4 " . " -sPAPERSIZE=a4 -r%s -sDEVICE=png16m -sOutputFile=%s %s";
        $command = sprintf($command, $density, $outputDirPath . "-key-%d.png", $originFilePath);

        $command .= ' >> /opt/lampp/htdocs/esignpro/trunk/imgconversionlogs.txt';

        exec($command, $output);

        $current_doc_key = Yii::app()->user->getState('doc_key' . Yii::app()->user->getId());

        $baseDocName = $this->getFileExtensionForSteps(null, $parentDocName);


        $command = "N=%s;for f in %s-key-*.png; do mv \$f %s-\$N.png;N=$((N + 1)); done";
        $command = sprintf($command, $imageCounter, $outputPath . DIRECTORY_SEPARATOR . $baseDocName, $outputPath . DIRECTORY_SEPARATOR . $baseDocName);
        //$command .= ' >> /opt/lampp/htdocs/esignpro/trunk/imgconversionlogs.txt';
        exec($command, $output);
        return true;
    }
    
    /**
     * function to insert Records to Pdf Table
     * @param int $totpages
     * @return boolean TRUE/FALSE
     */
    function insertRecordsToPdfTable($totpages = 1, $isFileRelative = false) {

        $pdfTableObj = null;
        //get the Document Name for Image
        if (!$isFileRelative) {
            $docNameForImage = $this->getFileExtensionForSteps(Yii::app()->params['img_conversion_format'], Yii::app()->user->getState('doc_name' . Yii::app()->user->getId()));
            $pdfTableObj = new Documents();

            $pdfTableObj->user_key = Yii::app()->user->getId();
            $pdfTableObj->oridoc_key = Yii::app()->user->getState('doc_key' . Yii::app()->user->getId());
            $pdfTableObj->converted_docname = $docNameForImage;
            $pdfTableObj->total_pages = $totpages;
            $pdfTableObj->deleted_docno = 0;
            $pdfTableObj->created_at = new CDbExpression('NOW()');
            $pdfTableObj->updated_at = new CDbExpression('NOW()');
        } else {
            $dockey = Yii::app()->user->getState('parent_dockey' . YII::app()->user->getId());
            $pdfTableObj = Documents::model()->find(array(
                'select' => 'pdfdoc_id,total_pages',
                'condition' => 'oridoc_key=:dockey',
                'params' => array(':dockey' => $dockey)));

            $pdfTableObj->total_pages = $totpages;
            $pdfTableObj->updated_at = new CDbExpression('NOW()');
        }

        if (!$pdfTableObj->save()) {
            Logs::addEvent(Yii::t('exceptions', 'PDFRECORDERROR') . " (Original Document: " . Yii::app()->user->getState('doc_name' . Yii::app()->user->getId()) . ")", Yii::app()->user->getId(), 'PDF-RECORD', 'error');
            return false;
        }

        Logs::addEvent(Yii::t('exceptions', 'PDFRECORDSUCCESS') . " (Original Document: " . Yii::app()->user->getState('doc_name' . Yii::app()->user->getId()) . ")", Yii::app()->user->getId(), 'PDF-RECORD', 'success');

        //set the Total Count from 
        Yii::app()->user->setState('doc_count' . Yii::app()->user->getId(), $totpages);

        return true;
    }

    /**
     * Function to convert File extension for Source and destination ...
     * @param string $fileExtension
     * @param string $filename
     * @return string $filename
     */
    function getFileExtensionForSteps($fileExtension, $filename = null) {
        if (is_null($filename)) {
            return false;
        }


        $filename = explode(".", $filename);
        $tempSize = count($filename) - 1;
        $filename[$tempSize] = $fileExtension;

        if (is_null($fileExtension)) {
            unset($filename[$tempSize]);
            return implode(".", $filename);
        }

        $filename = implode(".", $filename);

        return $filename;
    }

}