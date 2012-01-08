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
		<?php 
		$items=array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				//array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'WEPanel', 'url'=>array('/admin/default/index')),
				//array('label'=>'Настройки', 'url'=>array('/wepanel/params')),
				//array('label'=>'Разделы', 'url'=>array('/wepanel/section')),
				array('label'=>'Блоки', 'url'=>array('/admin/block')),
				//array('label'=>'Новости', 'url'=>array('/admin/news')),
				array('label'=>'Галереи', 'url'=>array('/admin/gallery')),
				//array('label'=>'Теги', 'url'=>array('/admin/tags')),
				//array('label'=>'Отзывы', 'url'=>array('/admin/guestbook')),
				//array('label'=>'Баннеры', 'url'=>array('/admin/banners')),
				array('label'=>'Сниппеты', 'url'=>array('/admin/snippet')),
				//array('label'=>'Login', 'url'=>array('/wepanel/login'), 'visible'=>Yii::app()->user->isGuest),
				//array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/wepanel/logout'), 'visible'=>!Yii::app()->user->isGuest)
			);
		
		$connectedModules=Yii::app()->getModules();
		$modules=Module::model()->findAll();
		$addModules=array();
		foreach($modules as $key=>$module)
		{
			array_push($items, array('label'=>$connectedModules[$module->name]['moduleName'], 'url'=>array('/admin/'.$module->name.'/default/index')));
		}
		
		$this->widget('zii.widgets.CMenu',array(
			'items'=>$items
		)); ?>
		<div id="right_buttons"><a href="/admin/setmodule" title="Подключаемые модули"><img src="/WE/images/59s.png"></a><a href="/admin/param" title="Настройки сайта"><img src="/WE/images/55s.png"></a><a href="/admin/logout" title="Выйти (<?=Yii::app()->user->name?>)"><img src="/WE/images/56s.png"></a></div>
	</div><!-- mainmenu -->
	<div id="leftcol">
		<h2 style="float:left;">Разделы</h2>
		<div style="text-align:right">
			<h4 id="add"><a href="/admin/section/create">Добавить раздел</a></h4>
		</div>
		<?$this->widget('CTreeView', array('data' => Section::model()->treeArray()));?>
	</div>
	<div id="content">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('WEPanel', array('/admin')),
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php if(!(Yii::app()->controller->action->id=='index' && Yii::app()->controller->id=='default') || (Yii::app()->controller->action->id=='index' && Yii::app()->controller->id=='default' && $this->module->id!='admin')):?>
	<div align="right">		
		<h4 id="add"><?php echo CHtml::link('Добавить запись', array('/'.(Yii::app()->controller->id!='default'?'admin/'.Yii::app()->controller->id:$this->module->id).'/create'));?></h4>
		<h4 id="del"><?=(!empty($_GET['item']) && Yii::app()->controller->action->id!='create'?CHtml::ajaxLink(
					"Удалить запись",
					//array('/'.(Yii::app()->controller->id!='default'?'admin/'.Yii::app()->controller->id:$this->module->id).'/delete', 'item' => $_GET['item'], 'redirect'=> ($this->module->id=='admin'?Yii::app()->controller->id:$this->module->id)),
					array('/'.(Yii::app()->controller->id!='default'?'admin/'.Yii::app()->controller->id:$this->module->id).'/delete', 'item' => $_GET['item']),
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
