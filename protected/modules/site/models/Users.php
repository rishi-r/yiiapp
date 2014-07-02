<?php
class Users extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{users}}';
    }
    
    public function primaryKey()
    {
    	return 'user_id';
    }
    
    /*public function relations() {
        return array(
            'user'=>array(self::HAS_ONE, 'User', array('api_key'=>'api_key')),
            );
    }*/
    
    /**
     * Generate Random Key for User
     * @return string
     */
    function getUserEncryptedKey() {
        $randKey = CommonFunctions::randomKey();
        if(!$this->checkUserKey($randKey))
        {
            $this->getUserEncryptedKey();
        }
        return $randKey;
    }
    
    function checkUserKey($userKey)
    {
        if($this->getUserKey($userKey))
        {
            return false;
        }
        return true;
    }
    
    function getUserKey($userKey)
    {
        $this->Model()->find(array(
                                'select'=>'user_key',
                                'condition'=>'user_key=:user_key',
                                'params'=>array(':user_key' => $userKey)
                            ));
        if(isset($userKey->user_key))
            return $userKey->user_key;
        else
            return false;
    }
    
    function sendUserConfirmationRequest($userObj=null,$isAutoCreated=false,$randomPassword=null)
    {
        if(!is_object($userObj) || is_null($userObj))
        {
                return false;
        }

        $body = null;
        $subject = "Activation mail";
        //$link = $this->getUserActivationKey($userObj);

        if(!$isAutoCreated)
        {
            $template_name = "email_confirmation";
            $title = Yii::app()->params['site_name']." | Activation mail";
            //--start template buffering--//
            ob_start();
            require(EMAIL_VIEW.$template_name.".php");
            $body = ob_get_contents();
            ob_end_clean();
            //--end template buffering--//
        }
        //echo $body;
        
        $mailObj = new MailFunctions;
        //$mailObj->name = $model->name;
        $mailObj->subject = $subject;
        $mailObj->toEmail = $userObj->email_id;
        $mailObj->body = $body;
        $mailObj->sendMail();
        return true;
    }
    
    function test()
    {
        Logs::addEvent("test success","123",'template-DataError','error');
    }
}
