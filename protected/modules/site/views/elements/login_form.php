<!-- login form -->
<?php 
$loginmodel=new LoginForm;

                    if(isset(Yii::app()->request->cookies['email_c']))
                    {
                            $is_cookie_e = Yii::app()->request->cookies['email_c'];
                            $is_cookie_p = Yii::app()->request->cookies['password_c'];
                            
                            $checked = 'checked';
                    }
                    else
                    {
                        $is_cookie_e = "";
                        $is_cookie_p = "";
                        $checked = "";
                    }
            $form=$this->beginWidget('CActiveForm', array(
				'id'=>'signin-form',
         		'enableClientValidation'=>true,
         		'enableAjaxValidation'=>true,
          		'action'=>Yii::app()->createUrl("site/login")
			)); ?>
              <?php //echo $form->error($loginmodel,'email',array('class'=>'cust_alert alert alert-danger','id'=>'LoginForm_email_em')); ?>
        	  <?php //echo $form->error($loginmodel,'password',array('class'=>'cust_alert alert alert-danger','id'=>'LoginForm_password_em')); ?>
         	  <?php //echo $form->error($loginmodel,'rememberMe'); ?>      
<div class="registrationform">
			  <div class="form-group username">
			    <?php echo $form->labelEx($loginmodel,'email'); ?>
				<?php echo $form->textField($loginmodel,'email',array('class'=>'form-control','placeholder'=>'Your Email', 'value'=>$is_cookie_e)); ?>
				
			  </div>
			  <div class="form-group paswrd">
			    
				<?php echo $form->labelEx($loginmodel,'password'); ?>
				<?php echo $form->passwordField($loginmodel,'password',array('value'=>$is_cookie_p,'class'=>'form-control','placeholder'=>'Your Password')); ?>
				
			   
			  </div>
			 
			  <div class="checkbox">
			    <?php echo $form->checkBox($loginmodel,'rememberMe',array('checked'=>$checked)); ?>
				<?php echo $form->label($loginmodel,'rememberMe'); ?>
				
			  </div>
			  <!--  <button type="submit" class="btn btn-default">Submit</button> -->
		  
          <?php echo CHtml::ajaxSubmitButton('Sign in',CHtml::normalizeUrl(array('site/login')),
                 array(
                     'dataType'=>'json',
                     'type'=>'post',
                     'success'=>'function(data) {
                 	   if($.isEmptyObject(data)){

                        	$("#hiddenajax").val(" ");
                        	$("#signin-form").submit();
                         	
                        }
                        else{
                        	 enableButton("#signin-btn","Please wait..");                       	                       	
	                        $.each(data, function(key, val) {
	                        //$("#"+key+"_em").text(val);                                                    
	                        //$("#"+key+"_em").show();
	                        $("#"+key+"_em").focus();
	                        custombox.alert(val,0,3500);
	                        return false;
                        });
                        } 
                        
                      
                    }',                    
                     'beforeSend'=>'function(){ 
                       	  disableButton("#signin-btn","Please wait..");
	 						
                      }'
                     ),array('id'=>'signin-btn','class'=>'pull-left btn btn-success ','data-style'=>'expand-left')); ?>	
         <!-- login form  ends-->
         
         <input type="hidden" id="hiddenajax" name="LoginForm[ajax]" value="signin-form" />
         <div class="col-lg-7 pull-right">
             Don't have an account? <a id="open_signup_panel" href="javascript:void(0)">Create one</a>
             <br/>
             <a class="" id="btnforgotpaswd" href="javascript:void(0)">Forgot Password?</a></div>
         <!--<div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>-->
         <?php $this->endWidget(); ?>
</div>
<div class="forgotpassword">
     <?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'signin-form',
         		'enableClientValidation'=>true,
         		'enableAjaxValidation'=>true,
          		'action'=>Yii::app()->createUrl("site/login"),
                                    'htmlOptions'=>array(
                                    'onsubmit'=>"return false;",
                                    'onkeypress'=>" if(event.keyCode ==13){   } "
                             ),
			)); ?>
     <div class="form-group username">
            <?php //echo $form->labelEx($loginmodel,'email'); ?>
            <?php echo $form->textField($loginmodel,'email',array('id'=>'forgot_email','class'=>'form-control','placeholder'=>'Your Email', 'value'=>$is_cookie_e)); ?>
      </div> 
    <input  class=" btn btn-primary btnresetpassword" data-style="expand-left" type="button" name="resetpassword" value="Reset Password"></input>&nbsp;&nbsp;
               <input  class="btn btn-warning btnresetcancel" type="button" name="btnresetcancel" value="Cancel"></input>
    <?php $this->endWidget(); ?>
</div>
<div class="forgotmsg hide">
    <span class="info-row">Reset Link has been sent to your mail ID. Please check your Mail box.</span>
</div>
        <input type="hidden" name="token" value="<?php echo Yii::app()->getRequest()->getCsrfToken()?>"/>
        <div class="clearfix"></div>
        

