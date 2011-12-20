<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'WEPanel',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.srbac.controllers.SBaseController',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
			'srbac' => array(
				'userclass'=>'User', //default: User
				'userid'=>'id', //default: userid
				'username'=>'login', //default:username
				'delimeter'=>'@', //default:-
				'debug'=>true, //default :false
				'pageSize'=>10, // default : 15
				'superUser' =>'admin', //default: Authorizer
				'css'=>'srbac.css', //default: srbac.css
				'layout'=>
				'application.views.layouts.main', //default: application.views.layouts.main,
				//must be an existing alias
				'notAuthorizedView'=> 'srbac.views.authitem.unauthorized', // default:
				//srbac.views.authitem.unauthorized, must be an existing alias
				'alwaysAllowed'=>array(
				//default: array()
				'SiteLogin','SiteLogout','SiteIndex','SiteAdmin',
				'SiteError', 'SiteContact'),
				'userActions'=>array('Show','View','List'), //default: array()
				'listBoxNumberOfLines' => 15, //default : 10
				'imagesPath' => 'srbac.images', // default: srbac.images
				'imagesPack'=>'noia', //default: noia
				'iconText'=>true, // default : false
				'header'=>'srbac.views.authitem.header', //default : srbac.views.authitem.header,
				//must be an existing alias
				'footer'=>'srbac.views.authitem.footer', //default: srbac.views.authitem.footer,
				//must be an existing alias
				'showHeader'=>true, // default: false
				'showFooter'=>true, // default: false
				'alwaysAllowedPath'=>'srbac.components', // default: srbac.components
				// must be an existing alias
			),
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'sko62267',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.4','::1'),
		),
		
	),

	// application components
	'components'=>array(
	     'thumb'=>array(
         'class'=>'ext.CThumbCreator.CThumbCreator',
			),
		'browser' => array(
			'class' => 'application.extensions.browser.CBrowserComponent',
			),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/wepanel/login'),
		),
		
		// uncomment the following to enable URLs in path-format
		
	'urlManager'=>array(
            'showScriptName' => false,  // что бы не цеплялся index.php к ссылкам
            'urlFormat'=>'path',
            'rules'=>array(
				'wepanel/<action:\w+>' => 'wepanel/<action>',
				'wepanel' => 'wepanel/index',
				
				'about/testimonials' => 'site/guestbook/url/testimonials/parenturl/about',
				
				'portfolio' => 'site/portfolio/url/portfolio',
				'portfolio/<page>.html' => 'site/portfoliopage/url/portfolio',
				'portfolio/<tag>' => 'site/portfolio/url/portfolio',
				
				'journal' => 'site/journal/url/journal',
				'journal/<page>.html' => 'site/journalpage/url/journal',
				'journal/<tag>' => 'site/journal/url/journal',
				
				'map' => 'site/map',
				'search' => 'site/search',
				
				'sendmail' => 'site/sendmail',
				
				'<url>'=>'site/section',
				'<parenturl>/<url>/'=>'site/section',
				'<rooturl>/<parenturl>/<url>/'=>'site/section',
				//'wepanel/'=>'wepanel/login',
                //'post/<url>/'=>'post/view',
                //'members/view/<member>' => 'members/view',
                //'post/page/<page>' => 'post/index',
                //'tag/<tag>' => 'tag/view',
                //'search/page/<page>/q/<q>' => 'search/index',
                //'search/q/<q>' => 'search/index',
                //'post' => 'post/index'
				),
            ),
		
			'authManager'=>array(
				// Path to SDbAuthManager in srbac module if you want to use case insensitive
				//access checking (or CDbAuthManager for case sensitive access checking)
				'class'=>'application.modules.srbac.components.SDbAuthManager',
				// The database component used
				'connectionID'=>'db',
				// The itemTable name (default:authitem)
				'itemTable'=>'WE_auth_items',
				// The assignmentTable name (default:authassignment)
				'assignmentTable'=>'WE_auth_assignments',
				// The itemChildTable name (default:authitemchild)
				'itemChildTable'=>'WE_auth_itemchildren',
			),
		
	
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		* */
		// uncomment the following to use a MySQL database
		
		
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=wecms',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'sko62267',
			'charset' => 'utf8',
			
			// включаем профайлер
			'enableProfiling'=>true,
			// показываем значения параметров
			'enableParamLogging' => true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				//array(
				//	'class'=>'CFileLogRoute',
				//	'levels'=>'error, warning, info',
				//),
					array(
						// направляем результаты профайлинга в ProfileLogRoute (отображается
						// внизу страницы)
						'class'=>'CProfileLogRoute',
						'levels'=>'error, warning, trace, profile, info',
						'enabled'=>true,
					),
				
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'skarah@mail.ru',
		'siteUrl'=>'http://wepanel.test.ru',
		'thumbPrefix'=>'thumb_',
		'thumbDir'=>'/content/',
		'thumbWidth'=>100,
		'thumbHeight'=>100,
	),
);
