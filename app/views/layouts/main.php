<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?=Yii::app()->params['charset']?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title><?if(Yii::app()->controller->action->id!='index'){?><?=$this->page['metaTitle']?> | Студия web-дизайна WebElement.Ru<?}else{?>Студия web-дизайна WebElement.Ru | Сделано руками, а не жопой<?}?></title>
<meta name="title" content="<?=$this->page['metaTitle']?> | Студия web-дизайна WebElement.Ru" />

<meta name="keywords" content="<?=$this->page['metaKeywords']?>" />
<meta name="description" content="<?=$this->page['metaDescription']?>" />
<meta name="revisit-after" content="2 weeks" />
<meta name="robots" content="all" />
<meta http-equiv="content-type" content="text/html; charset=<?=Yii::app()->params['charset']?>" />
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="shaparyuk@gmail.com">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <meta name='yandex-verification' content='7c2e0c68a4335479' />
    
	<link rel="shortcut icon" href="/favicon.ico">

	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<?=($this->page['mainUrl']=='/'?'<link rel="stylesheet" href="/css/main-page.css">':'')?>
	<?=($this->page['mainUrl']=='services' && empty($_GET['parenturl'])?'<link rel="stylesheet" href="/css/contacts-page.css"><link rel="stylesheet" href="/css/services-page.css">':'')?>
	<?=($this->page['mainUrl']=='services' && !empty($_GET['parenturl'])?'<link rel="stylesheet" href="/css/contacts-page.css"><link rel="stylesheet" href="/css/services-full.css">':'')?>
	<?=($this->page['mainUrl']=='portfolio' && empty($_GET['page'])?'<link rel="stylesheet" href="/css/contacts-page.css"> <link rel="stylesheet" href="/css/portfolio-page.css">':'')?>
	<?=($this->page['mainUrl']=='portfolio' && !empty($_GET['page'])?'<link rel="stylesheet" href="/css/contacts-page.css"> <link rel="stylesheet" href="/css/portfolio-detailed-page.css">':'')?>
	<?=($this->page['mainUrl']=='journal' && empty($_GET['page'])?'<link rel="stylesheet" href="/css/contacts-page.css"> <link rel="stylesheet" href="/css/blog-page.css">':'')?>
	<?=($this->page['mainUrl']=='journal' && !empty($_GET['page'])?'<link rel="stylesheet" href="/css/contacts-page.css"> <link rel="stylesheet" href="/css/blog-full-post.css">':'')?>	
	<?=($this->page['mainUrl']=='about' && $_GET['url']!='testimonials' && $_GET['url']!='contacts'?'<link rel="stylesheet" href="/css/contacts-page.css"><link rel="stylesheet" href="/css/services-full.css">':'')?>
	<?=($this->page['mainUrl']=='about' && $_GET['url']!='testimonials' && $_GET['url']=='contacts'?'<link rel="stylesheet" href="/css/contacts-page.css">':'')?>
	<?=($this->page['mainUrl']=='about' && $_GET['url']=='testimonials'?'<link rel="stylesheet" href="/css/contacts-page.css"><link rel="stylesheet" href="/css/testimonials-page.css"><link rel="stylesheet" href="/css/services-full.css">':'')?>
	<?=($this->page['mainUrl']=='map' || $this->page['mainUrl']=='sendmail'?'<link rel="stylesheet" href="/css/contacts-page.css"><link rel="stylesheet" href="/css/map.css">':'')?>
                		
			<script src="/js/libs/jquery-1.5.1.min.js"></script>
	<script src="/js/libs/modernizr-1.7.min.js"></script>
	<script type="text/javascript" src="js/jquery.nyroModal.custom.min.js"></script>
    <!--[if IE 6]>
        <script type="text/javascript" src="js/jquery.nyroModal-ie6.min.js"></script>
    <![endif]-->
	
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"> 
</head>
<body>
	<div id="container">

                <!-- Шапка -->
		<header class="png_bg">
			<div class="header_container">
				<a class="logo" title="Webelement" href="/"></a>
				<nav>
					<ul>			
						<li<?=($this->page['mainUrl']=='services'?' class="active"':'')?>><a href="/services/" title="Услуги">Услуги</a></li>
						<li<?=($this->page['mainUrl']=='portfolio'?' class="active"':'')?>><a href="/portfolio/">Портфолио</a></li>

						<li<?=($this->page['mainUrl']=='journal'?' class="active"':'')?>><a href="/journal/">Журнал</a></li>
						<li<?=($this->page['mainUrl']=='about'?' class="active"':'')?>><a href="/about/studio/">О нас</a></li>
			</ul>				</nav>
				<div class="contacts">
					<p><span>+7 (8793) </span>38-94-25</p>
					<p><a href="/about/contacts/" title="Контактная информация">Контактная информация</a></p>

				</div>
			</div> <!-- end .header_container -->
			<div class="clearfix"></div>
		</header> <!-- end header -->
		
		<?php if($this->page['mainUrl']=='/') $this->renderPartial('//layouts/indexsub');?>
		
		<?php if(!empty($this->page['subMenu'])) $this->renderPartial('//layouts/submenu');?>
		
		<?php if(!empty($this->page['portfolioMenu'])) $this->renderPartial('//layouts/portfoliosubmenu');?>
		
		<?php if(!empty($this->page['portfolioPageMenu'])) $this->renderPartial('//layouts/portfoliopagesubmenu');?>
		
		<?php if(!empty($this->page['newsMenu'])) $this->renderPartial('//layouts/newssubmenu');?>
		
		<?php if(!empty($this->page['newsPageMenu'])) $this->renderPartial('//layouts/newspagesubmenu');?>
		
		<?php if($this->page['mainUrl']=='map' || $this->page['mainUrl']=='sendmail') $this->renderPartial('//layouts/searchsub');?>
		
		<?php if(!empty($_GET['url']) && $_GET['url']=='services') $this->renderPartial('//layouts/services');?>
		
		<?php if(!empty($_GET['url']) && $_GET['url']=='notfound') $this->renderPartial('//layouts/notfoundsub');?>
				<!-- Main content -->
		<div id="main">
			<div class="main_container">
				<?php echo $content; ?>
				<div class="clearfix"></div>
<?if($this->page['mainUrl']=='about' && !empty($_GET['url']) && $_GET['url']=='contacts'){?>
				<div class="map clearfix">
				<h2>Вид из космоса</h2>
				<div class="map_bg png_bg">
					<div id="GMapContainer"><img src="http://webelement.ru/images/scheme.jpg"></div>
				</div>
<?
	$this->renderPartial('//layouts/orderform');
}?>
			</div><!-- end .main_container -->
		</div> <!-- end #main -->
		
<?php if(!empty($this->page['newsPageMenu'])) $this->renderPartial('//layouts/newspageundermenu');?>
						
			</div>	
<?if((empty($_GET['url']) || $_GET['url']!='contacts') && $this->page['mainUrl']!='/') $this->renderPartial('//layouts/callform');?>

	<footer>
		<div class="footer_container">
			<div class="left">
				&copy; 2001 — 2011 студия «WebElement.Ru»<br/>
				Электронная почта: <a href="mailto:info@webelement.ru?bсс=admin@host-kmv.ru" title="напишите нам">info@webelement.ru</a> 
			</div>
			<div class="center">
				 357500, Россия, г. Пятигорск, ул. Бунимовича, 7а, оф. 211 <br/>
				 Тел./факс: 8(8793) 38-94-25, 8(905) 499-55-50
			</div>
			<div class="right">
				<a href="/map/" title="Поиск и карта сайта">Поиск и карта сайта</a>
                <br />
                <a href="/about/contacts/#scheme" title="Схема презда">Схема проезда</a>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</footer> <!-- end footer -->
<?if($this->page['mainUrl']=='/') $this->renderPartial('//layouts/mainform');?>
	<script type="text/javascript" src="/js/jquery.nyroModal.custom.min.js"></script>
    <!--[if IE 6]>
        <script type="text/javascript" src="/js/jquery.nyroModal-ie6.min.js"></script>
    <![endif]-->

	<script type="text/javascript" src="/js/libs/jqdropdown/jqDropDown.jquery.min.js"></script>
    
    <script type="text/javascript" src="/js/jquery.tipTip.minified.js"></script> 
    <link rel="stylesheet" href="/css/tipTip.css"/> 

	<script type="text/javascript" src="/js/libs/jquery.placeholder.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
	        $("#time").jqDropDown();
	        /* ======= Форма email ======== */
	        jQuery('input[placeholder], textarea[placeholder]').placeholder();
		    $('.modal').nyroModal();
            
            /*======= tooltips ============*/
            $(".tip").tipTip({
                delay: 200,
                defaultPosition: 'top',
                attribute: 'rel',
                activation: 'click',
                edgeOffset: 15,
                keepAlive: true,
                enter: function(){
                    $('body').click(function(){
                        $('#tiptip_holder').fadeOut();
                        $('body').unbind('click');
                        return true;
                    });
                }
            });
	    });
    </script>

	 <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img,.png_bg,.journal_link,.bx-prev,.bx-next,.active,.pager-active,.logo,.right,.preview,.nyroModalCloseButton,#name,.nyroModalCont,.input,input,select,.chzn-container-single,a,#tiptip_content');
    </script>
    <![endif]--> 

    <script src="/js/validator.js"></script>
    <?php //require_once("metrics.inc.php"); ?>
</body>
</html>
