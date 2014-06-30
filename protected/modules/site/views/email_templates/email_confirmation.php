<html>
  <head>

    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  </head>
  <body bgcolor="#FFFFFF" text="#000000">
    
    
      
      <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
      <title>eSignly Account Activation</title>
<style type="text/css">

    /* Client-specific Styles */
#outlook a { padding: 0; }	/* Force Outlook to provide a "view in browser" button. */
body { width: 100% !important; }
.ReadMsgBody { width: 100%; }
.ExternalClass { width: 100%; display:block !important; } /* Force Hotmail to display emails at full width */
/* Reset Styles */
body { background-color: #eeeeee; margin: 0; padding: 0; }
img { outline: none; text-decoration: none; display: block;}
br, strong br, b br, em br, i br { line-height:100%; }
table td, table tr { border-collapse: collapse; }
.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
  color: black;
  text-decoration: none !important;
  border-bottom: none !important;
  background: none !important;
}
/* Fonts and Content */
a, a:visited {
  color: #077CB9;
}
body, td {
  font-family: 'Helvetica Neue', Arial, Helvetica, sans-serif;
  font-size: 14px;
  line-height: 1.4em;
}
/* Email styles */
.header {
  margin: 0 0 20px 0;
}
.header p {
  margin: 5px 0 0 0;
  color: #666;
}
.page {
  background: #fff;
  padding: 40px 40px 30px 40px;
  border: 1px solid #ccc;
}
.page-2 {
  margin-top: 10px;
}
h1 {
  margin: 0 0 10px 0;
  font-size: 18px;
  font-weight: bold;
}
p {
  margin: 10px 0;
}
.action {
  margin: 20px 0 25px 0;
}
a.button {
  margin: 0;
  background: #2AA3D3;
  color: #ffffff;
  cursor: pointer;
  padding: 9px 16px 8px 16px;
  text-decoration: none;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  -ms-border-radius: 4px;
  white-space: nowrap;
}
div.hr {
  border-top: 1px solid #cccccc;
  margin: 20px 0;
}
.sig {
  font-style: italic;
  padding-left: 1em;
}
.promo {
  margin: 20px 0;
  color: #666;
}
#footer {
  background: #cccccc;
  border-top: 1px solid #999999;
  border-bottom: 1px solid #999999;
  padding: 0 0 30px 0;
}
.footer-block {
  font-size: 12px;
  float: left;
  margin-top: 20px;
  padding: 0 40px 0 0;
  color: #555;
}
#footer .footer-block-last {
  padding-right: 0;
}
.footer-block a, .footer-block a:visited{
  color: #368BC6;
}

#custom_logo { max-width: 300px;max-height: 75px;}

ul{
  padding-left: 0;
}
/* Mobile-specific Styles */
@media only screen and (max-device-width: 480px) { 
  table.email-body, td.email-body {
    width: 100% !important;
  }
}
</style>
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
                            <h2 style="font-size: 30px;"><a href="<?php echo Yii:: app()->createAbsoluteUrl('/');?>" style="color:#428BCA; text-decoration: none;"><span class="color-teal">e</span>Signly</a>
                            </h2>
                        </div>
                        <p style="margin: 5px 0 0 0;color: #666;">The easiest way to sign and send documents online</p>
                      </div>
                      <div class="page" style="background: #fff;padding:40px 40px 30px 40px;border: 1px solid #ccc;color:black">
                        <h1 style="margin: 0 0 10px 0;font-size:18px;font-weight: bold;color:#000">Hey (<a class="moz-txt-link-abbreviated" href="mailto:<?php echo $userObj->email_id;?>"><?php echo $userObj->email_id;?></a>)
                        </h1>
                          <p style="margin:10px 0px;font-size:14px;line-height:1.4em;color:#000">
                              Welcome to the modern world of eco signature with best in class ease and security for your document signing needs.
                          </p>
                        <p style="margin:10px 0px;font-size:14px;line-height:1.4em;color:#000">Please Click on the Link below to Confirm your Account</p>
                        
                        <p><a href="<?php echo Yii::app()->createAbsoluteUrl("/site/UserActivate/token/$userObj->activation_key") ?>">Confirmation Link</a></p>
                        
                        <hr/>
                        <p>
                            <b>
                            For any help, please email at: <a href="mailto:help@esignly.com">help@esignly.com</a>
                            </b>
                        </p>
                         <p style="margin:10px 0px;font-size:14px;line-height:1.4em;color:#000">Congratulations for going paperless!<br>
                          <span style="margin-left:1em;">- 
                              <em>The eSignly Team</em>
                          </span>
                             <br/>
                             <a href="<?php echo Yii::app()->createAbsoluteUrl("/");?>">www.esignly.com</a>
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