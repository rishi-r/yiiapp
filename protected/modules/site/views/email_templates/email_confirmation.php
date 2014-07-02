<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
        <title><?php echo $title; ?></title>
        <style type="text/css">
            .ReadMsgBody {width: 100%; background-color: #ffffff;}
            .ExternalClass {width: 100%; background-color: #ffffff;}
            body     {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Arial, Helvetica, sans-serif}
            table {border-collapse: collapse;}
            a{
                color: #428BCA;
            }
            @media only screen and (max-width: 640px)  {
                body[yahoo] .deviceWidth {width:440px!important; padding:0;}    
                body[yahoo] .center {text-align: center!important;}  
            }

            @media only screen and (max-width: 479px) {
                body[yahoo] .deviceWidth {width:280px!important; padding:0;}    
                body[yahoo] .center {text-align: center!important;}  
            }

        </style>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
    </head>
    <body bgcolor="#FFFFFF" text="#000000">
        <table id="background-table" border="0" cellpadding="0"
               cellspacing="0" width="100%">
            <tbody>
                <tr style="border-collapse: collapse;">
                    <td style="font-family: 'Helvetica Neue', Arial, Helvetica,
                        sans-serif;font-size: 14px;line-height:
                        1.4em;border-collapse: collapse;" align="center"
                        bgcolor="#eeeeee">
                        <table class="email-body" border="0" cellpadding="20"
                               cellspacing="0" width="640">
                            <tbody>
                                <tr style="border-collapse: collapse;">
                                    <td class="email-body" style="font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif;font-size: 14px;line-height: 1.4em;border-collapse: collapse;" align="left" width="640">
                                        <div class="header" style="margin: 0 0 20px 0;">
                                            <div style="text-align: left;">
                                                <h2 style="font-size: 30px;"><a href="<?php echo Yii:: app()->createAbsoluteUrl('/'); ?>" style="color:#428BCA; text-decoration: none;"><span class="color-teal"><?php echo Yii::app()->params['site_name'];?></span></a>
                                                </h2>
                                            </div>
                                            <p style="margin: 5px 0 0 0;color: #666;">The easiest way to sign and send documents online</p>
                                        </div>
                                        <div class="page" style="background: #fff;padding:40px 40px 30px 40px;border: 1px solid #ccc;color:black">
                                            <h1 style="margin: 0 0 10px 0;font-size:18px;font-weight: bold;color:#000">Hey (<a class="moz-txt-link-abbreviated" href="mailto:<?php echo $userObj->email_id; ?>"><?php echo $userObj->email_id; ?></a>)
                                            </h1>
                                            <p style="margin:10px 0px;font-size:14px;line-height:1.4em;color:#000">
                                                Welcome to the modern world of eco signature with best in class ease and security for your document signing needs.
                                            </p>
                                            <p style="margin:10px 0px;font-size:14px;line-height:1.4em;color:#000">Please Click on the Link below to Confirm your Account</p>

                                            <p><a href="<?php echo Yii::app()->createAbsoluteUrl("/site/UserActivate/token/$userObj->activation_key") ?>">Confirmation Link</a></p>

                                            <hr/>
                                            <p>
                                                <b>
                                                    For any help, please email at: <a href="mailto:<?php echo Yii::app()->params['helpEmail'];?>"><?php echo Yii::app()->params['helpEmail'];?></a>
                                                </b>
                                            </p>
                                            <p style="margin:10px 0px;font-size:14px;line-height:1.4em;color:#000">Congratulations for going paperless!<br>
                                                <span style="margin-left:1em;">- 
                                                    <em>The <?php echo Yii::app()->params['site_name'];?> Team</em>
                                                </span>
                                                <br/>
                                                <a href="<?php echo Yii::app()->createAbsoluteUrl("/"); ?>"><?php echo Yii::app()->params['site_domain'];?></a>
                                            </p>
                                        </div>
                                        <!--  page --> </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

    </body>
</html>