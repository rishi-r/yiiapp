<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegistrationForm extends CFormModel {

    public $password;
    public $email;
    private $_helper = null;
    private $_password = null;
    private $_salt = null;
    private $_identity;

    public function __construct() {
        $this->_helper = new CommonFunctions();
    }

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            //array('password','required','length','min'=>6,'max'=>20),
            array('password', 'required'),
            array('password', 'length', 'min' => 4, 'max' => 20),
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'checkDuplicate')
        );
    }

    public function checkDuplicate($attribute, $params) {
        $usercount = User::model()->count(array(
            'condition' => 'email_id = :email_id',
            'params' => array(
                ':email_id' => $this->email,
            )
        ));
        if ($usercount) {
            return $this->addError($attribute, 'Account already Exists. You can try forgot password.');
        }
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        
    }

    /**
     * Function to create User ...
     * @param array $post
     * @return boolean
     * @todo Need to link to subscription type.
     */
    public function createAccount($post = null, $isAutoCreated = false, $blocked = 0, $socialReg = array()) {
        if (is_null($post)) {
            return false;
        }
        //check if silent registration is enabled or not
        $is_silentRegistration = Yii::app()->params['silentRegistraion'];

        $user = new Users();
        if (isset($post['password'])) {
            $random_password = $post['password'];
        } else {
            $random_password = $this->_helper->generateRandomPassword(Yii::app()->params['random_password_length']);
        }
        list($this->_password, $this->_salt) = $this->generateFirstEncryptedPassword($random_password);

        //-prepare user model to save
        if (isset($post['firstName'])) {
            $user->firstName = $post['firstName'];
        }
        $user->email_id = $post['email'];
        $user->password = $this->_password;
        $user->salt = $this->_salt;
        $user->user_key = $this->_helper->getEncryptedKey();
        $user->created_at = new CDbExpression('NOW()');
        $user->modified_at = new CDbExpression('NOW()');
        $user->activation_key = $this->_helper->getUserActivationKey($user);

        if (!empty($socialReg) && isset($post['social_provider']) && isset($post['social_identifier']) && isset($post['social_avatar']))        {
            $user->social_provider = $post['social_provider'];
            $user->social_identifier = $post['social_identifier'];
            $user->social_avatar = $post['social_avatar'];
        }

        if ($blocked == 2)
            $user->blocked = $blocked;
        else
            $user->blocked = (!$is_silentRegistration) ? 1 : $blocked;
        
       // if (!$user->save()) {
         //   return !$this->addError('error', 'Unable to Save User Data');
        //}

        //update Group ACL Records
        //$this->_helper->updateACLRecords($user, false);

        if (!$is_silentRegistration && !$isAutoCreated) {
            return $user->sendUserConfirmationRequest($user, $isAutoCreated, $random_password);
        }

        return true;
    }

    public function generateFirstEncryptedPassword($random_password) {
        $salt = $this->_helper->getRandomSalt();
        $password = $this->_helper->encryptPassword($random_password, $salt);
        return array($password, $salt);
    }

    public function resetPassword($email = null) {
        if (is_null($email) || empty($email)) {
            return array("status" => "error", "msg" => "Invalid Email Id.");
        }
        $userObj = User::model()->find(array(
            'select' => 'user_id,user_key,email,reset_key',
            'condition' => 'email = :email',
            'params' => array(
                ':email' => $email,
        )));
        if (!isset($userObj->user_id)) {
            return array("status" => "error", "msg" => "Email ID does not match any records.");
        }

        $reset_key = CommonFunctions::getUserEncryptedKey();
        $body = null;
        ob_start();
        Yii::app()->controller->renderPartial('resetmail', array('userObj' => $userObj, "resetKey" => $reset_key));
        $body = ob_get_contents();
        ob_end_clean();
        $subject = Yii::app()->params['resetlink_subject'];

        //update User object with New Reset link
        $userObj->reset_key = $reset_key;
        $userObj->save();
        //reset key updated

        CommonFunctions::sendMail($userObj, $subject, $body);
        return array("status" => "success", "msg" => "Reset Mail Sent.");
    }

    public function getResetView($token) {
        $userObj = User::model()->find(array(
            'select' => 'user_id,user_key,email,reset_key',
            'condition' => 'reset_key = :reset_key',
            'params' => array(
                ':reset_key' => $token,
        )));

        if (!isset($userObj->user_id)) {
            return 'Sorry! Invalid Reset Request.';
        }
        if (!Yii::app()->user->isGuest) {
            User::doManualLogin($userObj->user_key);
        }

        ob_start();
        Yii::app()->controller->renderPartial('resetView', array("token" => $token));
        $body = ob_get_contents();
        ob_end_clean();
        return $body;
    }

}
