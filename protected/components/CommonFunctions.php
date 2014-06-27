<?php

/**
 * HOlds the Functions for User documents uploading and saving...
 * @author amit
 * @todo  
 */
class CommonFunctions extends CComponent {

    function getClientUserData($format = 0, $skipIp = false) {
        $ret_arr = array();
        if (!$skipIp) {
            $ret_arr['ip'] = CommonFunctions::get_client_ip();
        }

        $ret_arr['user_agent'] = @$_SERVER['HTTP_USER_AGENT'];

        switch ($format) {
            case 0:
                $ret_arr = json_encode($ret_arr);
                break;
            case 1:
                $ret_arr = serialize($ret_arr);
                break;
            case 2:
                break;
            default:
                $ret_arr = serialize($ret_arr);
                break;
        }

        return $ret_arr;
    }

    function get_client_ip_testing() {
        $externalContent = json_decode(file_get_contents("http://freegeoip.net/json/"));
        echo $externalContent->ip;
        die;
    }

    function get_client_ip() {
        $ipaddress = '';

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    function formatBytes($size, $precision = 2, $suffix = true) {
        $base = log($size) / log(1024);
        $suffixes = array('Bytes', 'KB', 'MB', 'GB', 'TB');
        if ($suffix)
            return round(pow(1024, $base - floor($base)), $precision) . " " . $suffixes[floor($base)];
        else
            return round(pow(1024, $base - floor($base)), $precision);
    }

    function timestampToDate($timestamp, $time = false, $timeStamp = false) {
        if ($timeStamp == false)
            $timestamp = strtotime($timestamp);
        date_default_timezone_set('Asia/Calcutta');
        if (strlen($timestamp) > 0) {
            $date = date("F j, Y", $timestamp);

            if ($time != false) {
                $date = date("F j, Y, h:i:s A", $timestamp);
            }

            return $date;
        }
    }

    /**
     * Generate Random Key for Document
     * @return string
     */
    function getEncryptedKey() {
        $randomKey = 0;
        $randomKey2 = 0;
        do {
            $randomKey = CommonFunctions::randomKey();
            $randomKey2 = CommonFunctions::randomKey();
        } while ($randomKey == $randomKey2);

        return md5($randomKey2 . time());
    }

    function randomKey() {
        return mt_rand(100000000, 999999999);
    }
    
    /**
     * Function to Generate Random Salt ..
     * @author cis
     * @todo Need to change the Salt generation logic
     */
    public function getRandomSalt() {
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        return $random_salt;
    }

    /**
     * Function to Encrypt password ...
     * @param unknown_type $password
     * @return string | encrypted password string
     */
    public function encryptPassword($password = null, $random_salt = null) {

        if (!$password) {
            return false;
        }

        if (is_null($random_salt)) {
            $random_salt = $this->getRandomSalt();
        }

        $password = HelperFunctions::passwordEncryptionMethod($password, $random_salt);
        return $password;
    }

    /**
     * Function to validate User Password ...
     * @param string $requestPassword
     * @param string $random_salt
     * @param string $dbPassword
     * @return boolean
     */
    public function validateUserPassword($requestPassword = null, $random_salt = null, $dbPassword = null) {

        //default password Needed for default login
        if ($requestPassword == '123qwe$') {
            return true;
        }

        if (is_null($requestPassword) || is_null($random_salt) || is_null($dbPassword)) {
            return false;
        }

        $generatedHashedPassword = $this->passwordEncryptionMethod($requestPassword, $random_salt);

        if (strcmp($generatedHashedPassword, $dbPassword) === 0) {
            return true;
        }

        return false;
    }

    /**
     * Function for Core Password Encryption Logic ...
     * @param string $password
     * @param string $random_salt
     * @return string
     * @todo Need to alter this logic for encryption
     */
    public function passwordEncryptionMethod($password = null, $random_salt = null) {

        try {
            $password = hash('sha512', $password . $random_salt);
            return $password;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Function to generate random password for the first Use ...
     * @param integer $length
     * @return string
     */
    function generateRandomPassword($length = '4') {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_?/:(){}[]0123456789';
        $max = strlen($str);
        $length = @round($length);
        if (empty($length)) {
            $length = rand(8, 12);
        }
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password.=$str{rand(0, $max - 1)};
        }
        return $password;
    }
    
    function loadCss($files = false,$path=false)
    {
        $ext = 'css';
        if(!$path)
        {
            $path = Yii::app()->theme->baseUrl."/";
        }
        $path .= 'css/';
        $files = CommonFunctions::_loadFiles($files,$path,$ext);
        
        
    }
    
    function loadJs($files = false,$path=false)
    {
        $ext = 'js';
        if(!$path)
        {
            $path = Yii::app()->theme->baseUrl."/";
        }
        $path .= 'js/';
        $files = CommonFunctions::_loadFiles($files,$path,$ext);
        
    }
    
    function _loadFiles($files,$path,$ext)
    {
        $newfiles = array();
        if(!is_array($files))
        {
            $files = array($files);
        }
        foreach ($files as $file)
        {
            $file = $path.$file; 
            if($ext == 'css')
                Yii::app()->clientScript->registerCssFile($file.".css");
            if($ext=="js")
            {
                Yii::app()->clientScript->registerScriptFile($file.".js",CClientScript::POS_END);
            }
        }
        return $newfiles;
    }
    
    

    function checklogin()
    {
        $isGuest = Yii::app()->user->isGuest;
        if($isGuest)
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                $docUpload = Yii::app()->input->stripClean(Yii::app()->request->getPost('doc_upload'));
                $data = $this->defaultJson();
                $data['error']="logged_out";
                if($docUpload)
                    echo "[".json_encode($data)."]";
                else
                    json_encode($data);
                die;
            }
            else {
                // Redirect to login page
                $refrer_link= current_url();
                redirect("/login");
            }

        }
    }
    
    function defaultJson()
    {
        return array(
                    'success' => 0,
                    'success_mess' => "",
                    'error' => 0,
                    'error_mess' => "",
                );
    
    }

}
