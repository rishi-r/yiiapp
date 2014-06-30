<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.


Yii::setPathOfAlias('admin', dirname(__FILE__) . '/../modules/admin');
Yii::setPathOfAlias('/', dirname(__FILE__) . '/../modules/site');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."event".DIRECTORY_SEPARATOR);
define('ISTESTSITE',TRUE);
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
    
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.modules.admin.models.*',
	),
        'theme'=>'front-theme',
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin' => array(
                    'defaultController' => 'home',
                ),
		'site' => array(
                    'defaultController' => 'home',
                ),
	),
        //'defaultController' => 'home',
	// application components
	'components'=>array(
                'input'=>array(   
                    'class'         => 'CmsInput',  
                    'cleanPost'     => true,  
                    'cleanGet'      => true,  
                ),
                'user_agent'=>array(   
                    'class'         => 'User_agent'  
                ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
                'request'=>array(
                    'enableCsrfValidation'=>false,
                ),
                'authManager'=>array(
                        'class'=>'RDbAuthManager',
                        'connectionID'=>'db',
                        'defaultRoles'=>array('	', 'Guest'),
                ),
		'urlManager'=>array(
			'urlFormat' => 'path',
                        'showScriptName' => false,
			'rules'=>array(
                                '<controller:\w+>/<action:\w+>'=>'site/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
              	),
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=event',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
                        'tablePrefix'=> 'evt_'
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/home/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
                'mobileDetect' => array(
                    'class' => 'ext.MobileDetect.MobileDetect'
                ),
                'bootstrap'=>array(
                    'class'=>'bootstrap.components.Bootstrap',
                ),
                'mailer' => array(
                    'class' => 'ext.Yii-SwiftMailer.SwiftMailer',
                    'mailer' => 'smtp',
                    'security' => 'tls', 
                    'host'=>'smtp.cisinlabs.com',
                    'from'=>'test@test.com',
                    'username'=>'rishi.r@cisinlabs.com',
                    'password'=>'sdbyj4368',
                    'logMailerActivity' => true, 
                    'logMailerDebug' => true, 
                ), 
       ),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'noReplyEmail'=>'no-reply@example.com',
                'admin-theme' => 'admin_theme',
                'front-theme' => 'front_theme',
                // this is used in contact page
                'REMEMBER_ME_EXPIRE' => 10,
		'doc_size' => 1000000,
		'allowed_files' => 'pdf,doc,xls,docx,xlsx,png',
                'uploadPath'=>ROOT_PATH."userdocs".DIRECTORY_SEPARATOR,
                'sign_folder' => 'signature',
                'original_doc' => 'ori-docs',
		'pdf_conversion' => 'pdf-docs',
		'processed_doc'  =>  'processed-docs',
		'signingdoc_foldername' => 'signingdocs',
		'img_conversion_format' => 'png',
		'results_perpage' => 10,
		'not_allowed_files' => 'png,jpg,php,js,css,exe',
		'image_geometry' => '1275x1650',
		
	),
);