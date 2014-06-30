<?php
class User extends CActiveRecord
{
   /* public $phone;
    public $company;
    public $firstName;
    public $lastName;
    public $job_title;
    public $gender;
    public $industry;
    public $email;
    
 
    private $_identity;*/
    
    private $_helper = null;
    private $_newRow=null;
   

    function init()
    {
        $this->_helper = new HelperFunctions;
    }
    
    
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
    
    public function relations() {
        return array(
            'groupacl'=>array(self::HAS_ONE, 'GroupsAcl', array('user_id'=>'user_id')),
            'timezone'=>array(self::HAS_ONE, 'Timezones', array('timezone_id'=>'timezone_id')),
            
        );
    }
   
    
    
    /* public function rules()
	{
		return array(
			// username and password are required
			//array('phone', 'required'),
                        array('company, phone, firstName, lastName, gender', 'required'),
                        //array('company, phone, firstName, lastName, gender, industry, job_title, email', 'required'),
			
		);
	}*/
        
        
       /* public function authenticate($attribute,$params)
	{
		
		$this->_identity=new UserIdentity($this->phone, $this->company, $this->firstName, $this->lastName, $this->gender);
		//$this->_identity=new UserIdentity($this->phone, $this->company, $this->firstName, $this->lastName, $this->gender, $this->industry, $this->job_title, $this->email);
                if(!$this->_identity->authenticate())
                    $this->addError('company, phone, firstName, lastName, gender');
        }*/
    
    
    
        public function showUserDetail($userid = NULL)
        {
            if($userid == null)
            {
                $userid = Yii::app()->user->getId(); 
            }
            $userObj = User::model()->find(array(
                                                'select'=>'*',
                                                'condition'=>'user_key=:user_key',
                                                'params'=>array(':user_key'=>$userid)));


            $indObj = Industries::model()->findAll(array(
                                                        'select'=>'*',
                                                        //'condition'=>'is_deleted=0'
                                                        ));

            return array("userObj"=>$userObj, "indObj"=>$indObj);
        }
        
        public function checkOldPassword($password = null)
        {

            $userid = Yii::app()->user->getId(); 
            $userObj = User::model()->find(array(
                                                'select'=>'*',
                                                'condition'=>'user_key=:user_key',
                                                'params'=>array(':user_key'=>$userid)));

            return $userObj;
        }
        
        
        public function updateUserStatus($status=1,$user_Key = false)
        {
            $userid = Yii::app()->user->getId(); 
            if(!empty($user_Key))
                $userid = $user_Key;
            $records = $this->model()->find(array('select'=> '*',
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$userid)));
            if(empty($records))
            {
                return false;
            }
            if($records->blocked == 2)
            {
                    $records->blocked = 0;
                    $records->save();

            }
            return true;
        }
        
      public function doManualLogin($user_key,$skipAuth=0)
      {
          $userEmail = HelperFunctions::getDataFromDb('User','email','user_key',$user_key,$toSplit=false);
          $cookie_e = new CHttpCookie('email_c', "");
          $cookie_p = new CHttpCookie('password_c', "");
          Yii::app()->request->cookies['cookie_name'] = $cookie_e;
          Yii::app()->request->cookies['cookie_name'] = $cookie_p;
          $identity = new UserIdentity($userEmail,'test');
          $identity->_jump = true;
          if(!$skipAuth)
          {
                $identity->authenticate();
          }
          Yii::app()->user->login($identity,0);
          return true;
      }
      
      public function changePassword($pasword,$token)
      {
           $userObj = User::model()->find(array(
                                                            'select'=>'user_id,user_key,email,reset_key,password,salt',
                                                            'condition'=>'reset_key = :reset_key',
                                                            'params'=>array(
                                                                ':reset_key'=>$token,
                                                            )));
                      
            if(!isset($userObj->user_id))
            {
                return array("status"=>"error","msg"=>Yii::t('userMessages','INVALIDTOKENFORPASSWORDCHANGE'));
            }
            $salt = null;
            
            list($pasword,$salt) = User::generateFirstEncryptedPassword($pasword);
            $userObj->password = $pasword;
            $userObj->salt = $salt;
            $userObj->reset_key = null;
            $userObj->updated_at = new CDbExpression('NOW()');
            if($userObj->save())
            {
                LogEvents::addEvents(Yii::t('userMessages','PASSWORDRESETSUCCESS'),$userObj->user_key,'PASSWORD-CHANGED','success');
                return array("status"=>"success","msg"=>Yii::t('userMessages','PASSWORDRESETSUCCESS'));
            }
            LogEvents::addEvents(Yii::t('userMessages','PASSWORDRESETERROR'),$userObj->user_key,'PASSWORD-CHANGED','error');
            return array("status"=>"error","msg"=>Yii::t('userMessages','PASSWORDRESETERROR'));
      }
      
      public function generateFirstEncryptedPassword($random_password)
      {
              $salt = HelperFunctions::getRandomSalt();
              $password = HelperFunctions::encryptPassword($random_password,$salt);
              return array($password,$salt);
      }
      
      public function isSuperAdmin($user_key=null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
                
            $superAdminId = Yii::app()->params['superAdminId'];
            
            $userObj =  User::model()->find(array('select'=> 'user_id',
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$user_key)));
                
             if($superAdminId == $userObj->groupacl->group->group_id)
             {
                 return true;
             }
                
             return false;
            
        }
        
        public function isCorporateAdmin($user_key=null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
                
            $superAdminId = Yii::app()->params['corporateAdminId'];
            
            $userObj =  User::model()->find(array('select'=> 'user_id',
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$user_key)));
                
             if($superAdminId == $userObj->groupacl->group->group_id)
             {
                 return true;
             }
                
             return false;
        }
        
        
        public function isAdmin($user_key=null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
                
            $superAdminId = Yii::app()->params['adminId'];
            
            $userObj =  User::model()->find(array('select'=> 'user_id',
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$user_key)));
                
            if(isset($userObj->groupacl->group->group_id))
            {
                if($superAdminId == $userObj->groupacl->group->group_id)
                {
                    return true;
                }
            }
                
             return false;
        }
        
        public function isFreeAdmin($user_key=null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
                
            $freeAdmin = Yii::app()->params['freeadmin'];
            
            $userObj =  User::model()->find(array('select'=> 'user_id',
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$user_key)));
                
             if($freeAdmin == @$userObj->groupacl->group->group_id)
             {
                 return true;
             }
                
             return false;
        }
        public function isPaidAdmin($user_key=null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
                
            $paidAdmin = Yii::app()->params['paidadmin'];
            
            $userObj =  User::model()->find(array('select'=> 'user_id',
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$user_key)));
                
             if($paidAdmin == @$userObj->groupacl->group->group_id)
             {
                 return true;
             }
                
             return false;
        }
        
        public function isTeamOwner($user_key=null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
           
             $teamObj = Teams::model()->find(array('select'=> 'team_id',
                                                    'condition'=> 'created_by=:created_by',
                                                    'params'=> array(':created_by'=>$user_key)));
              
             if(isset($teamObj->team_id))
             {
                 return true;
             }
                
             return false;
        }
        
        public function isPaidMember($user_key = null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
                
            $paidMember = Yii::app()->params['paid_member'];
            
            $userObj =  User::model()->find(array('select'=> 'user_id',
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$user_key)));
                
             if($paidMember == @$userObj->groupacl->group->group_id)
             {
                 return true;
             }
                
             return false;
        }
        
        public function getCurrentPlanType($user_key=null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
           
             $groupObj = User::getCurrentPlan($user_key);
             
             if(isset($groupObj->plans_map_id))
             {
                 if($groupObj->plans_map_id == 0 || strlen($groupObj->plans_map_id) == 0)
                     return "free";
                 
                 
                 return $groupObj->plan;
             }
                
             return false;
        }
        
        public function canRemoveMember($userKey=null)
        {
            if(is_null($userKey))
            {
                $userKey = Yii::app()->user->getId();
            }
            
            if(User::isPaidAdmin($userKey) || User::isFreeAdmin($userKey) || User::isTeamOwner($userKey))
            {
                return true;
            }

            return false;
         }
        
         public function canCopyTemplate($userKey=null,$templateKey=null)
         {
             if(is_null($userKey))
             {
                 $userKey = Yii::app()->user->getId();
             }
             if(is_null($templateKey))
             {
                 return false;
             }
             
             $isCopied = TemplateSharing::isCopied($templateKey);
             $allowedQuota = User::getServiceCount($userKey,'templates');
             
             if(User::isTeamOwner($userKey) && !$isCopied && ($allowedQuota == -2 || $allowedQuota >=0))
             {
                 return true;
             }
             
             if((User::isPaidAdmin($userKey) || User::isFreeAdmin($userKey)) && !$isCopied && ($allowedQuota == -2 || $allowedQuota >=0))
             {
                 return true;
             }
             
             return false;
             
         }
        
        public function getCurrentPlan($user_key=null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
           
             $groupObj = GroupsAcl::model()->find(array('select'=> '*',
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$user_key)));
             
             return $groupObj;
        }
        public function upgradePlan($ret_data,$user_key = null,$bill_period = array(),$licensesData = false)
        {
            if(is_null($user_key) || strlen($user_key) == 0)
            {
                $user_key = Yii::app()->user->getId();
            }
            
            /* upgrading the user who is upgrading the other meber
            * as Atleast one paid admin is required on the team before user can upgrade other members.
            */
            
            if(User::getUserPlanType() == "free" && ($user_key != Yii::app()->user->getId()))
            {
                
                $groupObj = GroupsAcl::model()->find(array('select'=> '*',
                                                'condition'=> 'user_key=:user_key',
                                                'params'=> array(':user_key'=>Yii::app()->user->getId())));
            
            
                $old_plan_key = $groupObj->plans_map_key;
                $groupObj->plans_map_id = $ret_data->plans_map_id;
                $groupObj->plans_map_key = $ret_data->plans_map_key;
                $groupObj->plans_billing_cycle_map_id = $bill_period->plans_billing_cycle_map_id;
                $groupObj->plans_billing_cycle_map_key = $bill_period->plans_billing_cycle_map_key;
                
                $userSeat = User::checkUserSeatType();
                if($userSeat == Yii::app()->params['default_group_id']) // check is free member
                {
                    $groupObj->group_id = Yii::app()->params['paid_member']; // convert to paid member
                }
                else
                if($userSeat == Yii::app()->params['freeadmin']) // check is user free admin
                {
                    $groupObj->group_id = Yii::app()->params['paidadmin']; // convert to paid admin
                }
                
                $groupObj->update();

                $successMsg = Yii::t('planMessages','PLANUPGRADED').'Old plan key: '.$old_plan_key.' upgraded to new plan key:'.$ret_data->plans_map_key.' and plan type: '.$ret_data->plan_type." and reason: as Atleast one paid admin is required on the team before user can upgrade other members";
                LogEvents::addEvents($successMsg,Yii::app()->user->getId(),'Plan-upgrade','user-plan-upgraded');
            }
            
            UserUpgradeRequest::updateUserUpgradeRequest($user_key,1);
            $groupObj = GroupsAcl::model()->find(array('select'=> '*',
                                                'condition'=> 'user_key=:user_key',
                                                'params'=> array(':user_key'=>$user_key)));
            
            
            $old_plan_key = $groupObj->plans_map_key;
            $groupObj->plans_map_id = $ret_data->plans_map_id;
            $groupObj->plans_map_key = $ret_data->plans_map_key;
            $groupObj->plans_billing_cycle_map_id = $bill_period->plans_billing_cycle_map_id;
            $groupObj->plans_billing_cycle_map_key = $bill_period->plans_billing_cycle_map_key;
            
            
            $userSeat = User::checkUserSeatType($user_key);
            if($userSeat == Yii::app()->params['default_group_id']) // check is free member
            {
                $groupObj->group_id = Yii::app()->params['paid_member']; // convert to paid member
            }
            else
            if($userSeat == Yii::app()->params['freeadmin']) // check is user free admin
            {
                $groupObj->group_id = Yii::app()->params['paidadmin']; // convert to paid admin
            }
            
            $groupObj->update();
            
            $successMsg = Yii::t('planMessages','PLANUPGRADED').'Old plan key: '.$old_plan_key.' upgraded to new plan key:'.$ret_data->plans_map_key.' and plan type: '.$ret_data->plan_type;
            LogEvents::addEvents($successMsg,Yii::app()->user->getId(),'Plan-upgrade','user-plan-upgraded');
            
            //$this->planTransaction($response);
            //$this->planUpgradeMail();
            
            return $groupObj;
        }
        
        public function upgradeAPIPlan($ret_data,$bill_period = array(),$licensesData = false)
        {
            /* upgrading the API for the owner user 
            */
            $groupObj = GroupsAcl::model()->find(array('select'=> '*',
                                            'condition'=> 'user_key=:user_key',
                                            'params'=> array(':user_key'=>Yii::app()->user->getId())));
            
            $old_plan_key = $groupObj->api_plans_map_key;
            $groupObj->api_plans_map_id = $ret_data->plans_map_id;
            $groupObj->api_plans_map_key = $ret_data->plans_map_key;
            $groupObj->api_plans_billing_cycle_map_id = $bill_period->plans_billing_cycle_map_id;
            $groupObj->api_plans_billing_cycle_map_key = $bill_period->plans_billing_cycle_map_key;

            $groupObj->update();

            $successMsg = Yii::t('planMessages','APIPLANUPGRADED').'Old plan key: '.$old_plan_key.' upgraded to new plan key:'.$ret_data->plans_map_key.' and plan type: '.$ret_data->plan_type;
            LogEvents::addEvents($successMsg,Yii::app()->user->getId(),'Plan-upgrade','user-plan-upgraded');
            
            return $groupObj;
        }
        
        
        function planTransaction($response)
        {
            //$response
        }
        function planUpgradeMail()
        {
            //$response
        }
        
        
        function updateUserData($select_up,$value = null,$user_key = null)
        {
            if(is_null($user_key))
            {
                $user_key = Yii::app()->user->getId();
            }
            $userObj  = new User();
            if(is_array($select_up) && !empty ($select_up))
            {
                $str_select_up = implode(",", array_keys($select_up));
                $userData = $userObj->model()->find(array('select'=> $str_select_up.", user_id",
                                                'condition'=> 'user_key=:user_key',
                                                'params'=> array(':user_key'=>$user_key)));
                if(empty($userData))
                    return FALSE;
                
                foreach ($select_up as $key => $update_sel)
                {
                    $userData->$key = $update_sel;
                }
                $userData->save();
            }
            else
            {
                if(strlen($select_up) == 0)
                    return false;
                $userData = $userObj->model()->find(array('select'=> $select_up." , user_id",
                                                    'condition'=> 'user_key=:user_key',
                                                    'params'=> array(':user_key'=>$user_key)));
                if(empty($userData))
                    return FALSE;
                $userData->{$select_up} = $value;
                $userData->update();
            }
            return true;
        }
       
        
        function inviteusers()
        {
            $addressObj = new UserAddressBook();
            $emails = Yii::app()->request->getPost('emails');
            
            $fromEmail = Yii::app()->user->getName();
            if(!empty($emails))
            foreach ($emails as $email_key)
            {
                $address = $addressObj->getContactByAddressBookKey($email_key);
                $isRegistered = $this->isUserRegistered($address->contact_email,1);
                if(!empty($address) && empty($isRegistered))
                {
                    $userDetails = (object)array();
                    $userDetails->email = $address->contact_email;
                    $userDetails->contact_to_name = explode("@",$address->contact_email);
                    $template_subject = "Joining Invitation from eSign";
                    ob_start();
                    require(Yii::app()->getBasePath()."/email_templates/esign_invite_mail.php");
                    $body = ob_get_clean();
                    $subject='=?UTF-8?B?'.base64_encode($template_subject).'?=';
                    HelperFunctions::sendMail($userDetails,$subject,$body);
                    $address->invitation_key = HelperFunctions::getEncryptedKey();
                    $address->update();
                }
            }
            return array('success'=>1);
        }
        
        //@todo Need to change this to not return entire columns
        public function getUserByEmailId($emailId=null)
        {
            $ret_data = User::model()->find(array('select'=> '*',
                                                   'condition'=> 'email=:email',
                                                   'params'=> array(':email'=>$emailId)));

            return $ret_data;
        }
        
        public function getMemberPlansFeatureValue($member_key=null,$featureKey=null,$featureName=null)
        {
            
            if(is_null($featureKey) && is_null($featureName))
            {
                return false;
            }
            
            if(is_null($member_key))
            {
                $member_key = Yii::app()->user->getId();
            }
            
            $userObj = User::model()->find(array('select'=> 'user_id,user_key,email',
                                                   'condition'=> 'user_key=:user_key',
                                                   'params'=> array(':user_key'=>$member_key)));
            $plan_attribute_value = 0;
            if(!is_null($featureName))
            {
                if(!empty($userObj->groupacl->plan->plan_feature_map))
                {
                    foreach($userObj->groupacl->plan->plan_feature_map as $planData)
                    {
                        if($featureName ==$planData->feature_cat )
                        {
                            $plan_attribute_value = $planData->feature_value;
                            break;
                        }
                    }
                }
               return $plan_attribute_value;
                
            }else
            {
                if(!empty($userObj->groupacl->plan->plan_feature_map))
                {
                    foreach($userObj->groupacl->plan->plan_feature_map as $planData)
                    {
                        if($featureKey==$planData->feature_key)
                        {
                            $plan_attribute_value = $planData->feature_value;
                            break;
                        }
                        
                    }
                }
                return $plan_attribute_value;
            }

        }
        
        /*
         * @method : To get the Plan features as a defined format by developer
         * @params $format (1=array,2=json)
         * @params $featureKey (if true then Array keys will be featureKeys otherwise it will be featureText)
         */
        public function getPlanFeatures($userKey=null,$featureKey=true,$format=1)
        {
            if(is_null($userKey))
            {
                $userKey = Yii::app()->user->getId();
            }
            
             $userObj = User::model()->find(array('select'=> 'user_id,user_key',
                                                   'condition'=> 'user_key=:user_key',
                                                   'params'=> array(':user_key'=>$userKey)));
             $plan_attributes = array();
             $keyName = ($featureKey)?'feature_key':'feature_cat';
             switch($format)
             {
                 case 1:
                    foreach($userObj->groupacl->plan->plan_feature_map as $planData)
                    {
                        $plan_attributes[$planData->$keyName] = $planData->feature_value;
                    }
                    return $plan_attributes;
                 case 2:
                    foreach($userObj->groupacl->plan->plan_feature_map as $planData)
                    {
                        $plan_attributes[$planData->$keyName] = $planData->feature_value;
                    }
                    return json_encode($plan_attributes);
                 default :
                     return $plan_attributes;
             }
        }
                
        public function getTeamId($userKey=null)
        {
            if(is_null($userKey))
            {
                $userKey= Yii::app()->user->getId();
            }
             $teamObj = Teams::model()->find(array(
                                        'select'=>'team_id',
                                        'condition'=>'created_by = :created_by',
                                        'params'=>array(
                                        ':created_by'=>$userKey,
                                       )));
            //code if User is not Owner of the Group, get ID from Its own member record
            if(!isset($teamObj->team_id))
            {
                $teamObj = TeamMembers::model()->find(array(
                                             'select'=>'team_id',
                                             'condition'=>'member_key = :member_key AND status=1',
                                             'params'=>array(
                                             ':member_key'=>$userKey,
                                            )));
            }
          
            if(!isset($teamObj->team_id))
            {
                return 0;
            }
            return $teamObj->team_id;
            
          }
        
        function isUserRegistered($emailId = false,$check_blocked = false)
        {
            $blocked = "";
            if($check_blocked)
            {
                $blocked .= " AND blocked = 0 ";
            }
            $ret_data = User::model()->find(array('select'=> '*',
                                                   'condition'=> 'email=:email '.$blocked,
                                                   'params'=> array(':email'=>$emailId)));
            if(empty($ret_data))
                return false;
            else
            return $ret_data;
        }
        
        function doManualRegistration($user_data)
        {
            if(empty($user_data))
                return FALSE;
            $isRegistered = $this->isUserRegistered($user_data->contact_email);
            
            if(empty($isRegistered))
            {
                $userObj  = new User();
                $helperObj = new HelperFunctions();
                $userObj->user_key = $helperObj->getUserEncryptedKey();
                $userObj->email = $user_data->contact_email;
                $userObj->gender = "male";
                $userObj->blocked = 0;
                $userObj->created_at = new CDbExpression('NOW()');
                $userObj->updated_at = new CDbExpression('NOW()');
                $userObj->salt = $helperObj->getRandomSalt();
                $userObj->password = $helperObj->encryptPassword($helperObj->generateRandomPassword(),$userObj->salt);
                
                if(!$userObj->save())
                {
                    LogEvents::addEvents(Yii::t('registrationMessages','ERRORCREATIONACCOUNT')." User email ".$user_data->contact_email." client data: ".  HelperFunctions::getClientUserData(),'system-log','INVITE-USER-REGISTER','error');
                    return false;
                }

               //update Group ACL Records
               $free_plan_id = PlansMap::getPlanMapIdsByType('free');
               $this->_helper->updateACLRecords($userObj,false,$free_plan_id);
               return $userObj;
            }
            return array();
            
        }
        
        public function getTeamOwnerInfo($attribute=null)
        {
            if(empty($attribute))
            {
                return false;
            }
            $notAllowedAttribs = array("password","salt","activation_key");
            $teamId = User::getTeamId();
            $teamObj = Teams::model()->find(array('select'=> 'created_by',
                                                   'condition'=> 'team_id=:team_id ',
                                                   'params'=> array(':team_id'=>$teamId)));
            if(isset($teamObj->users->$attribute) AND !in_array($attribute, $notAllowedAttribs))
            {
                return $teamObj->users->$attribute;
            }
            return false;
        }
        

        public function getServiceCount($userKey=null,$specific=null)
        {     
            if(is_null($userKey))
            {
                $userKey = Yii::app()->user->getId();
            }
           
            $templateName =  'templates';
            $signingName =    'signings';
            $dateToCompare = date('Y-m');
            $result = array($signingName=>0,$templateName=>0);
            //1. Get Template count. need to enhance to look for sharedto field too if required.
             $criteria = new CDbCriteria();
             $criteria->select = "*";
             $criteria->addCondition('user_key ="'.$userKey.'"');
             $criteria->addCondition('feature_type = 2');
             $criteria->addSearchCondition('created_at',$dateToCompare."%",false,'AND');
             $result[$templateName] = UserFeatureUsage::model()->count($criteria);
             if($templateName == strtolower($specific))
             {   //echo User::getRemainingServiceCount($result[$templateName],null,strtolower($specific));die;
                return User::getRemainingServiceCount($result[$templateName],null,strtolower($specific),$userKey);
             }
             
            //2. Get Signing Counts
             $criteria = new CDbCriteria();
             $criteria->select = "*";
             $criteria->addCondition('user_key ="'.$userKey.'"');
             $criteria->addCondition('feature_type = 1');
             $criteria->addSearchCondition('created_at',$dateToCompare."%",false,'AND');
             //var_dump($criteria); die;
             $result[$signingName] = UserFeatureUsage::model()->count($criteria);
             if($result[$signingName]  && $signingName == strtolower($specific))
             {
                //need to enhance to accpet feature key as well
                return User::getRemainingServiceCount($result[$signingName],null,strtolower($specific),$userKey);
             }
            
            /*This code is to check the signing request based on recipients
             * $assignmentId = array();
            if(!empty($assignments))
            {
                foreach($assignments as $data)
                {
                    array_push($assignmentId, $data->assign_id);
                }
            }
            
            if(!empty($assignmentId))
            {
                $criteria = new CDbCriteria();
                $criteria->addInCondition("assign_id", $assignmentId);
                $result[$signingName] = SigningRequest::model()->count($criteria);
                if($result[$signingName]  && $signingName == strtolower($specific))
                {
                    //need to enhance to accpet feature key as well
                    return User::getRemainingServiceCount($result[$signingName],null,strtolower($specific),$userKey);
                }
                
            }*/
            
            return User::getRemainingServiceCount($result[$signingName],null,strtolower($specific),$userKey);
            
        }
        
        function getRemainingServiceCount($count=0,$featureKey=null,$featureName='templates',$userKey=null)
        {
           $featureCount = User::getMemberPlansFeatureValue($userKey,$featureKey,$featureName);
          
           if($featureCount == -1)
           {
               return -2;
           }
           $ret = User::getMemberPlansFeatureValue($userKey,$featureKey,$featureName)-$count;
           if($ret <= 0)
               $ret = 0;
           return $ret;
        }
        
        function getShareToList($userKey=null,$tmplKey=null)
        {
            if(is_null($userKey))
            {
                $userKey = Yii::app()->user->getId();
            }
            
            $teamId = User::getTeamId($userKey);
            $teamObj = Teams::model()->find(array('select'=> '*',
                                                       'condition'=> 'team_id=:team_id',
                                                       'params'=> array(':team_id'=>$teamId)));
            if(isset($teamObj->team_id))
            {
                
                $notAuthorisedUserIds = User::getUserIdsNotAuthorisedForServices($teamId,'templates');
                $alreadySharedUserIds = User::getAlreadySharedUserIds($tmplKey);
                if(empty($notAuthorisedUserIds))
                {
                    array_push($notAuthorisedUserIds,0);
                }
                
                //ignore Logged in member if he is in the fetched list
                array_push($notAuthorisedUserIds,Yii::app()->user->getId());
                $groupId = User::getGroupInfo('group_id');
                 switch($groupId)
                 {
                     case Yii::app()->params['default_group_id']:
                         $grpid = Yii::app()->params['paidadmin'];
                         $criteria = new CDbCriteria();
                         $criteria->together = true;
                         $criteria->select = "*";
                         $criteria->with = array('groups'=>array(
                                                 'select'=>'group_id',
                                                 'joinType'=>'INNER JOIN'));
                         //$criteria->compare('groups.group_id',$grpid,false);
                         $criteria->compare('team_id',$teamId,false);
                         $criteria->addNotInCondition('member_key',$notAuthorisedUserIds,'AND');
                         $teamRecords = TeamMembers::model()->findAll($criteria);
                         $contentLength = sizeof($teamRecords);
                         ob_start();
                         Yii::app()->controller->renderPartial('sharetomembers',array('teamMembers'=>$teamRecords,'teamOwner'=>$teamObj,"sharedusers"=>$alreadySharedUserIds));
                         $body = ob_get_contents();
                         ob_end_clean();
                         return array($body,$contentLength);
                         
                     case Yii::app()->params['freeadmin']:
                         $grpid = Yii::app()->params['freeadmin'];
                         $criteria = new CDbCriteria();
                         $criteria->together = true;
                         $criteria->select = "*";
                         $criteria->with = array('groups'=>array(
                                                 'select'=>'group_id',
                                                 'joinType'=>'INNER JOIN'));
                         $criteria->condition = "member_key <>".$userKey;
                         $criteria->compare('team_id',$teamId,false,'AND');
                         $criteria->addNotInCondition('member_key', $notAuthorisedUserIds,'AND');
                         $teamRecords = TeamMembers::model()->findAll($criteria);
                         $contentLength = sizeof($teamRecords);
                         ob_start();
                         Yii::app()->controller->renderPartial('sharetomembers',array('teamMembers'=>$teamRecords,'teamOwner'=>$teamObj,"sharedusers"=>$alreadySharedUserIds));
                         $body = ob_get_contents();
                         ob_end_clean();
                         return array($body,$contentLength);
                         
                     case Yii::app()->params['paidadmin']:
                         $grpid = Yii::app()->params['paidadmin'];
                         $criteria = new CDbCriteria();
                         $criteria->together = true;
                         $criteria->select = "*";
                         $criteria->with = array('groups'=>array(
                                                 'select'=>'group_id',
                                                 'joinType'=>'INNER JOIN'));
                         $criteria->condition = "member_key <>".$userKey;
                         $criteria->compare('team_id',$teamId,false,'AND');
                         $criteria->addNotInCondition('member_key', $notAuthorisedUserIds,'AND');
                         $teamRecords = TeamMembers::model()->findAll($criteria);
                         $contentLength = sizeof($teamRecords);
                         ob_start();
                         Yii::app()->controller->renderPartial('sharetomembers',array('teamMembers'=>$teamRecords,'teamOwner'=>$teamObj,"sharedusers"=>$alreadySharedUserIds));
                         $body = ob_get_contents();
                         ob_end_clean();
                         return array($body,$contentLength);    
                     
                     case Yii::app()->params['paid_member']:
                         $grpid = Yii::app()->params['paid_member'];
                         $criteria = new CDbCriteria();
                         $criteria->together = true;
                         $criteria->select = "*";
                         $criteria->with = array('groups'=>array(
                                                 'select'=>'group_id',
                                                 'joinType'=>'INNER JOIN'));
                         $criteria->condition = "member_key <>".$userKey;
                         $criteria->compare('team_id',$teamId,false,'AND');
                         $criteria->addNotInCondition('member_key', $notAuthorisedUserIds,'AND');
                         $teamRecords = TeamMembers::model()->findAll($criteria);
                         $contentLength = sizeof($teamRecords);
                         ob_start();
                         Yii::app()->controller->renderPartial('sharetomembers',array('teamMembers'=>$teamRecords,'teamOwner'=>$teamObj,"sharedusers"=>$alreadySharedUserIds));
                         $body = ob_get_contents();
                         ob_end_clean();
                         return array($body,$contentLength);
                         // case for super admin
                     case 1:
                         $grpid = Yii::app()->params['freeadmin'];
                         $criteria = new CDbCriteria();
                         $criteria->together = true;
                         $criteria->select = "*";
                         $criteria->with = array('groups'=>array(
                                                 'select'=>'group_id',
                                                 'joinType'=>'INNER JOIN'));
                         $criteria->condition = "member_key <>".$userKey;
                         $criteria->compare('team_id',$teamId,false,'AND');
                         //$criteria->addNotInCondition('member_key', $notAuthorisedUserIds,'AND');
                         $teamRecords = TeamMembers::model()->findAll($criteria);
                         $contentLength = sizeof($teamRecords);
                         ob_start();
                         Yii::app()->controller->renderPartial('sharetomembers',array('teamMembers'=>$teamRecords,'teamOwner'=>$teamObj,"sharedusers"=>$alreadySharedUserIds));
                         $body = ob_get_contents();
                         ob_end_clean();
                         return array($body,$contentLength);
                         
                         break;
                     
                 }
                
            }
            
            return false;
            
        }
        
        function getAlreadySharedUserIds($tmplKey=null)
        {
            if(is_null($tmplKey))
            {
                return null;
            }
            $userKeys = array();
            $templateKey = HelperFunctions::getDataFromDb('Templates','template_id','template_key',$tmplKey,$toSplit=false);
            $tmplSharingObj = TemplateSharing::model()->findAll(array('select'=> '*',
                                                       'condition'=> 'template_id=:template_id',
                                                       'params'=> array(':template_id'=>$templateKey)));
            if(!empty($tmplSharingObj))
            {
                foreach($tmplSharingObj as $tmplData)
                {
                    array_push($userKeys,$tmplData->shared_to);
                }
            }
            
            return $userKeys;
            
        }
        
        function getUserIdsNotAuthorisedForServices($teamId=0,$specificServices=null)
        {
            if(!$teamId || is_null($specificServices))
            {
                return false;
            }
            
            $teamId = User::getTeamId(); 
            
            $teamMembers = TeamMembers::model()->findAll(array('select'=> 'member_key',
                                                       'condition'=> 'team_id=:team_id AND status=1',
                                                       'params'=> array(':team_id'=>$teamId)));
            
            $teamMemberKeys = array();
            
            if(!empty($teamMembers))
            {
                foreach($teamMembers as $tm)
                {
                    
                    $count = User::getServiceCount($tm->member_key,$specificServices);
                   
                    if($count==0)
                    {
                        array_push($teamMemberKeys, $tm->member_key);
                    }
                }
                
            }
          
            return $teamMemberKeys;
            
        }
        
        function getGroupInfo($field='group_id',$userKey=null)
        {
            if(is_null($userKey))
            {
                $userKey = Yii::app()->user->getId();
            }
            
            $userObj = User::model()->find(array('select'=> '*',
                                                       'condition'=> 'user_key=:user_key',
                                                       'params'=> array(':user_key'=>$userKey)));
            if(isset($userObj->groupacl->group->$field))
            {
                return $userObj->groupacl->group->$field;
            }
            
            return null;
            
        }
        
  
        function hasPaymentAuthority($userKey=null)
        {
            // *** need to make some of changes more as custom authority also
            if(is_null($userKey))
            {
                $userKey = Yii::app()->user->getId();
            }
            
            if(User::isTeamOwner($userKey))
                return true;
            
            $teamId = User::getTeamId($userKey);
            if($teamId == 0)
            {
                return true;
            }
            
            $isBelongToTeam = Teams::isBelongToSameTeam($userKey);
            if(!$isBelongToTeam)
            {
                 $sysDetails = HelperFunctions::getClientUserData();
                 LogEvents::addEvents('Invalid User Action  user_key:-'.$userKey." System Details : ".$sysDetails,Yii::app()->user->getId(),'TEAM--AUTH','error');
                 return false;
            }
            
            
           $teamMemberObj = TeamMembers::model()->find(array(
                                        'select'=>'team_member_id,member_key,payment_authority',
                                        'condition'=>'member_key = :member_key AND status=1 AND team_id=:team_id',
                                        'params'=>array(':team_id'=>$teamId,"member_key"=>$userKey
                                       )));
           if(isset($teamMemberObj->payment_authority))
           {
               if($teamMemberObj->payment_authority==1)
               {
                    return true;
               }
               return false;
           }
           
            return false;
        }
        
        function hasAuthorityToDowngrade()
        {
            
            return true;
        }

        function getUserSeatType($userKey = null)
        {
            if(is_null($userKey) || strlen($userKey) == 0)
            {
                $userKey = Yii::app()->user->getId();
            }
            
            $user_data = User::model()->find(array('select'=> '*',
                                            'condition'=> 'user_key=:user_key',
                                            'params'=> array(':user_key'=>$userKey)));
            
            $type =  @$user_data->groupacl->group->group_name;
            $type_id =  @$user_data->groupacl->group->group_id;
            if($type_id == Yii::app()->params['superAdminId'])
            {
               
                if(User::isTeamOwner($userKey))
                {
                    return "Team Owner";
                }
                else
                {
                    return $type ;
                }
            }
            else
            {
                if(User::isTeamOwner($userKey))
                {
                    return "Team Owner";
                }
                else
                {
                    return $type;
                }
                
            }
        }
        
        function checkUserSeatType($userKey = null)
        {
            if(is_null($userKey) || strlen($userKey) == 0)
            {
                $userKey= Yii::app()->user->getId();
            }
            
            $user_data = User::model()->find(array('select'=> '*',
                                            'condition'=> 'user_key=:user_key',
                                            'params'=> array(':user_key'=>$userKey)));
            
            if(!isset($user_data->groupacl->group->group_id))
            {
                return Yii::app()->params['default_group_id'];
                // check if user is normal user not exist in group
            }
            $type_id =  @$user_data->groupacl->group->group_id;
            
            if($type_id == 1)
            {
                // check if user is team admin in case of super admin
                if(!isset($user_data->groupacl->plan->plan_type))
                {
                    if(User::isTeamOwner($userKey))
                    {
                        return Yii::app()->params['adminId'];  // admin of ateam
                    }
                    else
                    {
                        return Yii::app()->params['default_group_id'];
                        // check if user normal user in case of super admin
                    }
                }
                // check if user is paid admin in case of super admin
                if(@$user_data->groupacl->plan->plan_type == "paid")
                {
                   return Yii::app()->params['paidadmin']; 
                }
            }
            return $type_id;
        }
        function getUserPlanType($userKey = null)
        {
            if(is_null($userKey))
            {
                $userKey= Yii::app()->user->getId();
            }
            
            $user_data = User::model()->find(array('select'=> '*',
                                            'condition'=> 'user_key=:user_key',
                                            'params'=> array(':user_key'=>$userKey)));
            
            if(!isset($user_data->groupacl->plan->plan_type))
            {
                return "free";
                // check if user is normal user not exist in group
            }
            else
            {
                return @$user_data->groupacl->plan->plan_type;
            }
        }
        function getUserPlan($userKey = null)
        {
            if(is_null($userKey))
            {
                $userKey= Yii::app()->user->getId();
            }
            
            $user_data = User::model()->find(array('select'=> '*',
                                            'condition'=> 'user_key=:user_key',
                                            'params'=> array(':user_key'=>$userKey)));
            
            if(!isset($user_data->groupacl->plan->plan_type))
            {
                return false;
                // check if user is normal user not exist in group
            }
            else
            {
                return $user_data->groupacl->plan;
            }
        }
        
        function getUserAPIPlan($userKey = null)
        {
            if(is_null($userKey))
            {
                $userKey= Yii::app()->user->getId();
            }
            
            $user_data = User::model()->find(array('select'=> '*',
                                            'condition'=> 'user_key=:user_key',
                                            'params'=> array(':user_key'=>$userKey)));
            
            if(!isset($user_data->groupacl->api_plan->plan_type))
            {
                return false;
                // check if user is normal user not exist in group
            }
            else
            {
                return $user_data->groupacl->api_plan;
            }
        }
        
        public function isSelfUpgraded($userKey=null)
        {
            if(is_null($userKey))
            {
                $userKey = Yii::app()->user->getId();
            }
            
            $teamLicenceDistObj = TeamLicenseDistribute::model()->find(array(
                "select"=>"*",
                "condition"=> "user_key =:user_key AND distributer_key=:distributer_key",
                "params"=>array("user_key"=> $userKey, "distributer_key"=> $userKey),
                "order" => "created_at DESC"
                    ));
            
            if(empty($teamLicenceDistObj))
                return false;
            
            if($teamLicenceDistObj->subscribe->user_wallet->user_key == $userKey)
            {
                return true;
            }
//            if(isset($teamLicenceDistObj->team_license_distribute_id))
//            {
//                return true;
//            }
            return false;
            
        }
        
        function canDeleteAssignment($assign_key)
        {
           
            $signingRequestObj = SigningRequest::model()->findAll(array(
                'select'=>"*",
                'condition'=>'assign_key = :assign_key',
                'params'=>array(':assign_key'=>$assign_key)));
            
            if(!empty($signingRequestObj))
            {
                $datactr = 0;
                $ctr1 = 0;
                $ctr2 = 0;
                foreach($signingRequestObj as $data)
                {
                    $datactr++;
                    if($data->status == 0)
                    {
                        $ctr1++;
                    }
                    if($data->status==2)
                    {
                        $ctr2++;
                    }
                    
                }
                if(($datactr == $ctr1) || ($datactr == $ctr2))
                {
                   return true;
                }
                return false;
            }
        }
        
        function generateApiKey()
        {
            $jsondata = array(
                            'error' => 0,
                            'success' => 0,
                            'error_mess' => "",
                            'success_mess' => ""
                        );
            
            $owner_key = null;
            $isOwner = true;
            if(User::getTeamId() != 0)
            {
                $owner_key =  User::getTeamOwnerInfo('user_key');
                $isOwner = User::isTeamOwner();
            }
            
            if(!$isOwner)
            {
                $jsondata['error'] = 1;
                $jsondata['error_mess'] = "Not authorized to make this process";
            }
            else
            {
               $domainName =  Yii::app()->request->getPost('domainName');
               $webhookUrl =  Yii::app()->request->getPost('webhookUrl');
               $hostIP =  Yii::app()->request->getPost('hostIP');
               
               /*if(!User::check_domain($domainName))
               {
                    $jsondata['error'] = 1;
                    $jsondata['error_mess'] = "Please enter a valid domain name";
               }
               else*/
               if(!User::check_domain($webhookUrl))
               {
                    $jsondata['error'] = 1;
                    $jsondata['error_mess'] = "Please enter a valid webhook url name";
               }
               else
               {
                    $jsondata['success'] = 1 ;
                    $jsondata['success_mess'] = "API key generated successfully.";
                    
                    $domainName = parse_url($domainName);
                    $domainName = (isset($domainName['host'])) ? $domainName['host'] : $domainName['path'];
                    
                    $jsondata['domainName'] = $domainName;
                    if(strpos($webhookUrl, "http://") === false)
                    {
                        $webhookUrl = "http://".$webhookUrl;
                    }
                    $jsondata['webhookUrl'] = $webhookUrl;
                    
                    $jsondata['hostIP'] = (!filter_var($hostIP, FILTER_VALIDATE_IP)) ? gethostbyname($domainName) : trim($hostIP);
                    $jsondata['genApiKey'] = hash_hmac ("sha1" , $domainName.time(),"secret");
                    $update = array(
                                    'api_key' => $jsondata['genApiKey'],
                                    'webhook_url' => $webhookUrl,
                                    'domain_name' => $domainName,
                                    'domain_host_ip' => $jsondata['hostIP'],
                                );
                    User::updateUserData($update);
               }
            }
            
            return $jsondata;
        }
        
        
        function check_domain($url)
        {
            $user_pat = "^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$";
            
            if(strpos($url, "http://") === false)
            {
                $url = "http://".$url;
            }
            
            if(preg_match("|".$user_pat."|i", $url) === 0)
            {
                return false;
            }
            return true;   
        }
        
        function checkUserIP($userObj)
        {
            $nowIP = HelperFunctions::getClientUserData(2);
            if($userObj->domain_host_ip != $nowIP['ip'])
                return false;
            else
                return true;
        }
        
        
        public function getAPIServiceCount($APIKey=null,$specific=null)
        {     
            if(is_null($userKey))
            {
                $userKey = Yii::app()->user->getId();
            }
           
            //$templateName =  'API_SIGNING'; need to done later
            $signingName = 'API_SIGNING';  
            
            $result = array($signingName => 0);
            
            //1. Get API SIGNING count.
             $result[$signingName] = APIUsageLogs::getUsageLogCountByAPIKey($APIKey);
             if($result[$signingName]  && $signingName == strtolower($specific))
             {
                //need to enhance to accpet feature key as well
                return User::getAPIRemainingServiceCount($result[$signingName],null,strtolower($specific));
             }
        }
        
        function getAPIRemainingServiceCount($count=0,$featureKey=null,$featureName='API_SIGNING')
        {
           $featureCount = User::getMemberPlansFeatureValue($userKey,$featureKey,$featureName);
          
           if($featureCount == -1)
           {
               return -2;
           }
           return User::getMemberPlansFeatureValue($userKey,$featureKey,$featureName) - $count;
        }
        
        function getUserByAPIKey($apiKey = '')
        {
            return User::model()->find(array(
                        'select' => '*',
                        'condition' => 'api_key =:api_key AND blocked=0',
                        'params' => array(':api_key'=> $apiKey)
                    ));
        }
        
        function findBySocial($provider, $identifier)
        {
            return User::model()->find(array(
                        'select' => '*',
                        'condition' => 'social_provider =:social_provider AND social_identifier=:social_identifier',
                        'params' => array(':social_provider'=> $provider,":social_identifier" => $identifier)
                    ));
        }
}