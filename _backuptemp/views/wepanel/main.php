<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/WE/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/WE/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/WE/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/WE/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" id="page">
	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				//array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'WEPanel', 'url'=>array('/wepanel/index')),
				//array('label'=>'Настройки', 'url'=>array('/wepanel/params')),
				//array('label'=>'Разделы', 'url'=>array('/wepanel/sections')),
				array('label'=>'Блоки', 'url'=>array('/wepanel/blocks')),
				array('label'=>'Новости', 'url'=>array('/wepanel/news')),
				array('label'=>'Галереи', 'url'=>array('/wepanel/galleries')),
				array('label'=>'Теги', 'url'=>array('/wepanel/tags')),
				array('label'=>'Отзывы', 'url'=>array('/wepanel/guestbook')),
				array('label'=>'Баннеры', 'url'=>array('/wepanel/banners')),
				array('label'=>'Сниппеты', 'url'=>array('/wepanel/snippets')),
				//array('label'=>'Login', 'url'=>array('/wepanel/login'), 'visible'=>Yii::app()->user->isGuest),
				//array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/wepanel/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
		<div id="right_buttons"><a href="/wepanel/params" title="Настройки сайта"><img src="/WE/images/55s.png"></a><a href="/wepanel/logout" title="Выйти (<?=Yii::app()->user->name?>)"><img src="/WE/images/56s.png"></a></div>
	</div><!-- mainmenu -->
	<div id="leftcol">
		<h2 style="float:left;">Разделы</h2>
		<div style="text-align:right">
			<h4 id="add"><a href="/wepanel/sections/act/create">Добавить раздел</a></h4>
		</div>
		<?$this->widget('CTreeView', array('data' => Section::model()->treeArray()));?>
	</div>
	<div id="content">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('WEPanel', array('/wepanel/index')),
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php if(!(Yii::app()->controller->action->id=='index' && Yii::app()->controller->id=='wepanel')):?>
	<div align="right">		
		<h4 id="add"><?php echo CHtml::link('Добавить запись', array('/wepanel/'.Yii::app()->controller->action->id.'/act/create'));?></h4>
		<h4 id="del"><?=(!empty($_GET['item']) && $_GET['act']!='create'?CHtml::ajaxLink(
					"Удалить запись",
					array('/wepanel/'.Yii::app()->controller->action->id.'/act/delete', 'item' => $_GET['item'], 'redirect'=> Yii::app()->controller->action->id),
					array('type' => 'GET', 'update' => '#msgs'),
					array('title' => 'Удалить запись', 'confirm' => "Вы действительно хотите удалить эту запись?")
					):'')?></h4>
		
	</div>
	<?php endif?>
	<?php echo $content; ?>
	</div>
	<div id="msgs"></div>
	<div id="footer">
		&copy; <?php echo date('Y'); ?> <a href="http://www.webelement.ru">WebElement</a>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
