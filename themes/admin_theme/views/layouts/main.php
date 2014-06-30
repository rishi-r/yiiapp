<!DOCTYPE html>
<html>
    <head>
        <?php
        include_once 'meta_css.php';
        include_once 'constants_js.php';
        ?>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo  Yii::app()->createUrl('/');?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                AdminLTE
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <?php
                                include_once 'messages.php';
                        ?>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <?php
                                include_once 'notifications.php';
                        ?>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <?php
                                include_once 'tasks.php';
                        ?>
                        <!-- User Account: style can be found in dropdown.less -->
                        <?php
                                include_once 'user_sett.php';
                        ?>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <?php
                    include_once 'left_bar.php';
                ?>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    
                    <?php if(isset($this->breadcrumbs)):?>
                            <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                                    'links' => $this->breadcrumbs,
                                    'encodeLabel' => false,
                                    'homeLink' => false,
                                    'separator' => ''
                            )); ?><!-- breadcrumbs -->
                    <?php endif?>
                    <!--ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol-->
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php echo $content; ?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <div class="cust_alert text-muted" id="cust_alert">
        </div>
<!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<?php
$jsArr = array(
            // jQuery UI 1.10.3
            'jquery-ui-1.10.3.min',
            //Bootstrap
            'bootstrap.min',
            // iCheck
            'plugins/iCheck/icheck.min',
            );
if(isset($this->uploader_js) && $this->uploader_js)
{
    $jsArr2 = array(
            // File uploader
            'plugins/jquery-ui/ui/minified/jquery.ui.core.min',
            'plugins/jquery-ui/ui/minified/jquery.ui.widget.min',
            'plugins/file_upload/tmpl.min',
            'plugins/file_upload/load-image.min',
            'plugins/file_upload/canvas-to-blob.min',
            'plugins/file_upload/jquery.iframe-transport',
            'plugins/file_upload/jquery.fileupload',
            'plugins/file_upload/jquery.fileupload-ip',
            'plugins/file_upload/jquery.fileupload-ui',
            );
    $jsArr = array_merge($jsArr,$jsArr2);
}

    $jsArr2 = array(
            // main app js
            'custom/app',
            // dashboard js
            'custom/dashboard'
            );
    $jsArr = array_merge($jsArr,$jsArr2);

CommonFunctions::loadJs($jsArr,$this->theme_path);
?>
    </body>
</html>