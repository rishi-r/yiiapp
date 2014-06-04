<?php
class Logs extends CActiveRecord
{
	
 	public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
 
    public function tableName()
    {
        return '{{logs}}';
    }
    
    
    /**
    * Helper function to Log Event by User/Admin/System ...
    * @param string $category
    * @param string $type
    * @param string $from
    * @param string $sysdetails
    * @param string $msg
    * @return boolean true/false
    */
    public function addEvent($msg=null,$from='sys',$category='sys-events',$type='error',$sysdetails='localhost')
    {

            $logObj = new Logs();
            $logObj->category = $category;
            $logObj->type = $type;
            $logObj->from = $from;
            $logObj->sysdetails = CommonFunctions::getClientUserData();
            $logObj->msg = $msg;	
            $logObj->created_at = new CDbExpression('NOW()');
            $logObj->updated_at = new CDbExpression('NOW()');

            if(!$logObj->save())
            {
                    return false;
            }
            return true;
    }
	
	
}