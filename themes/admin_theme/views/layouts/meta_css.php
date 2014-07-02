<meta charset="UTF-8">
<title><?php echo Yii::app()->params['site_name'];?> | Dashboard</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<?php

$cssArr = array(
            // bootstrap 3.0.2
            'bootstrap.min',
            //font Awesome
            'font-awesome.min',
            );
if(isset($this->uploader_css) && $this->uploader_css)
{
    $cssArr2 = array(
            // uploader files
            'uploader/file_uploader',
            'uploader/jquery.fileupload-ui',
            'uploader/uploadify.jGrowl',
            );
    $cssArr = array_merge($cssArr,$cssArr2);
}
$cssArr2 = array(
            // main style
            'AdminLTE'
            );
$cssArr = array_merge($cssArr,$cssArr2);
CommonFunctions::loadCss($cssArr,$this->theme_path);
?>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.<?php echo $this->theme_path; ?>js/1.3.0/respond.min.js"></script>
<![endif]-->