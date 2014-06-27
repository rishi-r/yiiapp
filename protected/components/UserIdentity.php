<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;
    private $_userkey;
    private $_username;
    public $_jump = false;

    public function authenticate() {

        $userData = User::model()->find(array(
            'select' => 'user_id,user_key,email,password,salt,blocked',
            'condition' => 'email=:email AND (blocked=0 OR blocked=2)',
            'params' => array(':email' => $this->username),
        ));



        if (empty($userData)) {
            return !$this->errorCode = self::ERROR_PASSWORD_INVALID;
        }

        if ($this->_jump == false) {
            // code to detect the Auto generated Users
            if ($userData->blocked == 2) {
                $userData->blocked = 0;
                $userData->save();
            }
            //code ends
            if (!isset($userData->email)) {
                return !$this->errorCode = self::ERROR_USERNAME_INVALID;
            }

            $helper = new HelperFunctions();

            if ($helper->validateUserPassword($this->password, $userData->salt, $userData->password)) {

                //set the id and other data
                $this->_id = $userData->user_key;
                $this->_username = $userData->email;

                return !$this->errorCode = self::ERROR_NONE;
            }


            return !$this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {

            $this->_id = $userData->user_key;
            $this->_username = $this->username;
            return !$this->errorCode = self::ERROR_NONE;
        }
    }

    /* (non-PHPdoc)
     * @see CUserIdentity::getId()
     */

    public function getId() {
        return $this->_id;
    }

    /* (non-PHPdoc)
     * @see CUserIdentity::getName()
     */

    public function getName() {
        return $this->_username;
    }
    
    /* public function authenticate()
      {
      $users=array(
      // username => password
      'demo'=>'demo',
      'admin'=>'admin',
      );
      if(!isset($users[$this->username]))
      $this->errorCode=self::ERROR_USERNAME_INVALID;
      elseif($users[$this->username]!==$this->password)
      $this->errorCode=self::ERROR_PASSWORD_INVALID;
      else
      $this->errorCode=self::ERROR_NONE;
      return !$this->errorCode;
      } */

}
