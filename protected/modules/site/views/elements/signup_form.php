<div class="col-md-4">
    <div class="box box-info">
        <div class="box-header">
<!--            <h3 class="box-title">Date picker</h3>-->
        </div>
        <div class="box-body">
            <?php
        $registerModel = new RegistrationForm;
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'signup-form',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
            'action' => Yii::app()->createUrl("home/login")
        ));
        ?>
            <!-- Date range -->
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <?php echo $form->textField($registerModel, 'email', array('class' => 'form-control input-lg', 'placeholder' => 'Your Email')); ?>
                </div><!-- /.input group -->
            </div><!-- /.form group -->

            <!-- Date and time range -->
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-key"></i>
                    </div>
                    <?php echo $form->passwordField($registerModel, 'password', array('class' => 'form-control input-lg', 'placeholder' => 'Create a password')); ?>
                </div><!-- /.input group -->
            </div><!-- /.form group -->
            
            <div >
                Use at least one lowercase letter, one numeral, and seven characters.
            </div>
            <br/>
            <?php
            echo CHtml::ajaxSubmitButton('Sign up', CHtml::normalizeUrl(array('home/register')), array(
                'dataType' => 'json',
                'type' => 'post',
                'beforeSend' => 'function(){  
                    
                           var email = $("#RegistrationForm_email").val();                      
                           var emailRegexStr = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/i);
                           var passwd = $("#RegistrationForm_password").val();
                           if(!emailRegexStr.test(email))
                            {
                                $("#signup-btn").removeAttr("disabled","disabled");
                                $("#RegistrationForm_email").focus();
                                custombox.alert("Please Enter valid Email id.",0,3000);
                                return false;
                            }
                            if(passwd=="")
                            {
                                $("#signup-btn").removeAttr("disabled","disabled");
                                $("#RegistrationForm_password").focus();
                                custombox.alert("Please Enter valid Password.",0,3000);
                                return false;
                            }
                            commonfn.disableButton("#signup-btn","GET started");
                            custombox.alert("Please wait...");
                     	  
                      }',
                'success' => 'function(result){
                 	var datamsg = $.parseJSON(JSON.stringify(result));

                        if(datamsg.status=="success")
                        {
                                $("#modal-form").slideUp("slow");
                                $("#RegistrationForm_email").val("");
                                $("#RegistrationForm_password").val("");
                                custombox.alert("Congrats! Your Account has been created.",1,5000);
                                //google analytical code//
                                /*var _gaq = [["_setAccount", "UA-1535232-38"], ["_setDomainName", "test.com"],["_setSiteSpeedSampleRate", 100], ["_trackPageview","/home/thankyou"]];
                                var g = document.createElement("script"),
                                s = document.scripts[0];
                                g.async = 1;
                                g.src = "//stats.g.doubleclick.net/dc.js";
                                s.parentNode.insertBefore(g, s);*/
                                //----------------------//

                        }
                        else
                        {
                            datamsg.msg = $.parseJSON(datamsg.msg);
                            var newMsg = datamsg.msg.RegistrationForm_password;
                            if(newMsg instanceof Array)
                            {
                                $("#RegistrationForm_password").val("").focus();
                                custombox.alert(newMsg[0],0,3500);
                            }else
                            {
                                newMsg = datamsg.msg.RegistrationForm_email;
                                $("#RegistrationForm_email").focus();
                                $("#RegistrationForm_password").val("");
                                custombox.alert(newMsg[0],0,3500);
                            }


                        }
                        $("#signup-btn").removeAttr("disabled","disabled");
                        commonfn.enableButton("#signup-btn");
                        return;
                 	  		
                 	  }
                 	  '
                    ), array('id' => 'signup-btn', 'value' => Yii::app()->params['site_name'], 'class' => 'btn btn-lg col-lg-12 btn-success pull-left signup-btn-main', 'data-style' => 'expand-left'));
            ?>
            <div class="clearfix"></div>
            <br/>
            <div>
                By clicking "Sign up for <?php echo Yii::app()->params['site_name'];?>", you agree to our terms of service and privacy policy.<br/> We will send you account related emails occasionally.
            </div>
            <div class="clearfix"></div>
            <?php $this->endWidget(); ?>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    
</div><!-- /.col (right) -->


<div class="col-xs-12">
    <article class="started-form">
        <div class="text-primary hide" id="modal-msg" style="color: #FFF;">
            <i class="icon-envelope"></i> Congrats! Your Account has been created Successfully. Please check your mail for verification.</h4>
        </div>
    </article>
</div>
