<?php

Class MailFunctions extends CComponent
{
     /**
     * DocHelper::init()
     * 
     * @return
     */
    public $name = null;
    public $subject;
    public $body;
    public $fromEmail;
    public $toEmail;
    public $auto = TRUE;
    public $headers = null;
    public function init()
    {
        parent::init();
    }
    
    function setHeader()
    {
        if($this->auto)
        {
            $this->fromEmail = Yii::app()->params['noReplyEmail'];
        }
        else
        {
            $this->fromEmail = Yii::app()->params['adminEmail'];
            //Yii::app()->mailer->From($this->email);
        }
        //Yii::app()->mailer->setFrom($this->fromEmail) ;
        if($this->name != null)
        {
            $this->name = '=?UTF-8?B?'.base64_encode($this->name).'?=';
            //Yii::app()->mailer->FromName = $this->name;
        }
        $this->subject = '=?UTF-8?B?'.base64_encode($this->subject).'?=';
        $this->headers =    "From: $this->name <{$this->fromEmail}>\r\n".
                            "Reply-To: {$this->fromEmail}\r\n".
                            "MIME-Version: 1.0\r\n".
                            "Content-Type: text/plain; charset=UTF-8";
    }
    function setBody()
    {
        $this->body = "From Email :".$this->fromEmail."</br> Message : ".  $this->body;
        if(strlen($this->toEmail) == 0)
        {
            $this->toEmail = Yii::app()->params['adminEmail'];
        }
    }
            
    function sendMail()
    {
        $this->setHeader();
        $this->setBody();
        Yii::app()->mailer->AddAddress($this->toEmail);
        Yii::app()->mailer->Subject = ($this->subject);
        Yii::app()->mailer->MsgHTML($this->body);
        Yii::app()->mailer->Send();
        return true;	
    }
}