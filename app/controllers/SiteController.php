<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
		
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				//'class'=>'CCaptchaAction',
				'class'=>'MyCCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	
	public function actionIndex()
	{
		Params::model()->setSiteParams();
		
		$this->page['metaTitle']='Главная | Сделано руками, а не жопой';
		$this->page['metaKeywords']=Yii::app()->params['siteKeywords'];
		$this->page['metaDescription']=Yii::app()->params['siteDescription'];
		$this->page['mainUrl']='/';
		
		$this->page['portfolio']=Portfolio::model()->findAllByAttributes(array('mark'=>1),array('order'=>'date desc','limit'=>'3'));
		for($i=0;$i<sizeof($this->page['portfolio']);$i++){
			$this->page['portfolioImage'][$i]=Images::model()->findByAttributes(array('sid'=>$this->page['portfolio'][$i]->id,'model_name'=>'Portfolio'));
		}
		
		$this->page['news']=News::model()->findAll(array('order'=>'date desc'));
		
		$this->page['indexText']=Block::model()->findByPk(2);
		$this->page['jobText']=Block::model()->findByPk(1);
		
		$this->page['bannerInfo']=Banner::model()->findAll();
		for($i=0;$i<sizeof($this->page['bannerInfo']);$i++){
			$this->page['bannerImage'][$i]=Images::model()->findByAttributes(array('sid'=>$this->page['bannerInfo'][$i]->id,'model_name'=>'Banner'));
		}
		
		$this->page['randomFromGuestbook']=Guestbook::model()->find(array('order'=>'rand()'));
		
		
		$this->render('index');
	}
	
	public function actionSection()
	{
		//$this->page['callForm']=new CallForm;
		
		if(empty($_GET['parenturl']))
		{
			if(Section::model()->countByAttributes(array('url'=>$_GET['url']))>0)
				$model=Section::model()->findByAttributes(array('url'=>$_GET['url']));
		}
		else
		{
			if(Section::model()->countByAttributes(array('url'=>$_GET['parenturl']))>0)
			{
				$parent=Section::model()->findByAttributes(array('url'=>$_GET['parenturl']));
				$model=Section::model()->findByAttributes(array('url'=>$_GET['url']));
			}
		}
		
		if(!empty($model))
		{
			$this->page=!empty($_GET['parenturl'])?Section::model()->getPageData(array($_GET['url'],$_GET['parenturl'])):Section::model()->getPageData(array($_GET['url']));
			$this->render('innerpage',array('model'=>$model,));
		}
		//else $this->redirect('/map/');
			
	}


	public function actionGuestbook()
	{
		//$this->page['callForm']=new CallForm;
		
		$this->page=(!empty($_GET['parenturl'])?Section::model()->getPageData(array($_GET['url'],$_GET['parenturl'])):Section::model()->getPageData(array($_GET['url'])));
		$section=Section::model()->findByAttributes(array('url'=>$_GET['url']));
		$this->page['text']=$section->content;
		$this->page['sectionMainId']=$section->id;
		
		$model=Guestbook::model()->findAll(array('order'=>'id desc'));
				
		$this->render('guestbook', array('model'=>$model));
	}

	public function actionPortfolio()
	{
		//$this->page['callForm']=new CallForm;
		
		$this->page=(!empty($_GET['parenturl'])?Section::model()->getPageData(array($_GET['url'],$_GET['parenturl'])):Section::model()->getPageData(array($_GET['url'])));
		$section=Section::model()->findByAttributes(array('url'=>$_GET['url']));
		$this->page['text']=$section->content;
		$this->page['sectionMainId']=$section->id;
		$this->page['portfolioMenu']=Portfolio::model()->getTagList(32);
		
		if(!empty($_GET['tag']) && $_GET['tag']=='theme') $_GET['tag']='sanatory';
		
		if(!empty($_GET['tag']) && Tag::model()->countByAttributes(array('alias'=>$_GET['tag']))>0)
		{
			$model=Yii::app()->db->createCommand()
				->select('WE_portfolio.*')
				->from('WE_portfolio')
				->join('WE_portfolio_tag', 'WE_portfolio_tag.pid=WE_portfolio.id')
				->join('WE_tag', 'WE_tag.id=WE_portfolio_tag.tid')
				->where('WE_tag.alias=:tag',array(':tag'=>$_GET['tag']))
				->queryAll();
		}
		elseif(!empty($_GET['tag']))
		{
			$model=$_GET['tag']=='fresh'
						? Portfolio::model()->findAll(array('order'=>'date desc','limit'=>'6'))
						: (
							$_GET['tag']=='list'
							? Portfolio::model()->findAll(array('order'=>'date desc'))
							:'');
		}
		else $model=Portfolio::model()->findAllByAttributes(array('mark'=>1));
		
		if(!empty($model))
		{
			for($i=0;$i<sizeof($model);$i++)
			{
				$tag[$i]=Portfolio::model()->getTagList($section->id,$model[$i]['id']);
				$pic[$i]=Images::model()->findByAttributes(array('sid'=>$model[$i]['id'],'model_name'=>'Portfolio'));
			}
			$this->page['tags']=$tag;
			$this->page['pics']=$pic;
			$this->page['total']=Portfolio::model()->count();
			$this->page['title']=(empty($_GET['tag'])?'Избранные работы':($_GET['tag']=='fresh'?'Свежие работы':($_GET['tag']=='list'?'Все работы одним списком':'Работы по темам')));
			
			$this->render('portfolio',array('model'=>$model,));
		}
		else $this->redirect('/map/');
	}

	public function actionPortfoliopage()
	{
		if(!is_numeric($_GET['page']))
		{
			$this->redirect('/map/');
			Yii::app()->end();			
		}

		
		$this->page=Section::model()->getPageData(array($_GET['url']));
		$this->page['portfolioPageMenu']=Portfolio::model()->getTagList(32,$_GET['page']);
		$this->page['model']=Portfolio::model()->findByPk($_GET['page']);
		
		if(!empty($this->page['model']))
		{
			$this->page['metaTitle']=(!empty($this->page['model']->meta_title)?$this->page['model']->meta_title:$this->page['model']->name).' | '.$this->page['metaTitle'];
			$pic=Images::model()->findAllByAttributes(array('sid'=>$_GET['page'],'model_name'=>'Portfolio'));
			if(Portfolio::model()->count('id<'.$_GET['page'])>0) $this->page['prevProject']=Portfolio::model()->find('id<'.$_GET['page']);
			if(Portfolio::model()->count('id>'.$_GET['page'])>0) $this->page['nextProject']=Portfolio::model()->find('id>'.$_GET['page']);
			$this->render('portfoliopage',array('pic'=>$pic));
		}
		else 
		{
			$_GET['url']='notfound';
			$this->render('notfound');
		}
	}
	
	public function actionJournal()
	{
		$this->page=Section::model()->getPageData(array($_GET['url']));
		$section=Section::model()->findByAttributes(array('url'=>$_GET['url']));
		$this->page['text']=$section->content;
		$this->page['sectionMainId']=$section->id;
		$this->page['newsMenu']=News::model()->getTagList(20);
		
		if(!empty($_GET['tag']) && $_GET['tag']=='theme') $_GET['tag']='seo';
		
		if(!empty($_GET['tag']) && Tag::model()->countByAttributes(array('alias'=>$_GET['tag']))>0)
			$model=Yii::app()->db->createCommand()
				->select('WE_news.*')
				->from('WE_news')
				->join('WE_news_tag', 'WE_news_tag.nid=WE_news.id')
				->join('WE_tag', 'WE_tag.id=WE_news_tag.tid')
				->where('WE_tag.alias=:tag',array(':tag'=>$_GET['tag']))
				->queryAll();
		elseif(!empty($_GET['tag']) && $_GET['tag']=='recommend') 
			$model=News::model()->findAllByAttributes(array('mark'=>1));
		elseif(empty($_GET['tag'])) 
			$model=News::model()->findAll(array('order'=>'date desc'));
		else
		{
			$this->redirect('/map/');
			Yii::app()->end();
		}
				
		for($i=0;$i<sizeof($model);$i++)
		{
			$tag[$i]=News::model()->getTagList($section->id,$model[$i]['id']);
			$pic[$i]=Images::model()->findByAttributes(array('sid'=>$model[$i]['id'],'model_name'=>'News'));
		}
		$this->page['tags']=$tag;
		$this->page['pics']=$pic;
		$this->page['total']=News::model()->count();
		$this->page['title']=(empty($_GET['tag'])?'Все статьи':($_GET['tag']=='recommend'?'Настоятельно рекомендуем почитать':'Статьи по темам'));
		
		$this->render('news',array('model'=>$model,));
	}
	
	public function actionJournalpage()
	{	
		if(!is_numeric($_GET['page']))
		{
			$this->redirect('/map/');
			Yii::app()->end();			
		}
			
		$this->page=Section::model()->getPageData(array($_GET['url']));
		$this->page['newsPageMenu']=News::model()->getTagList(20,$_GET['page']);
		$this->page['model']=News::model()->findByPk($_GET['page']);
		
		if(!empty($this->page['model']))
		{
			list($dt,$time)=split(' ',$this->page['model']->date);
			$date=split('-',$dt);
			$this->page['model']->date=$date[2].'.'.$date[1].'.'.$date[0];
			
			$this->page['metaTitle']=strip_tags(!empty($this->page['model']->meta_title)?$this->page['model']->meta_title:$this->page['model']->name).' | '.$this->page['metaTitle'];
			$pic=Images::model()->findAllByAttributes(array('sid'=>$_GET['page'],'model_name'=>'News'));
			if(News::model()->count('id<'.$_GET['page'])>0) $this->page['prevNews']=News::model()->find('id<:page', array(':page'=>$_GET['page']));
			if(News::model()->count('id>'.$_GET['page'])>0) $this->page['nextNews']=News::model()->find('id>:page', array(':page'=>$_GET['page']));
			$this->render('newspage',array('pic'=>$pic));
		}
		else 
		{
			$_GET['url']='notfound';
			$this->render('notfound');
		}
	}
	
	
	public function actionMap()
	{
		Params::model()->setSiteParams();
		
		$this->page['metaTitle']='Страница не найдена';
		$this->page['metaKeywords']=Yii::app()->params['siteKeywords'];
		$this->page['metaDescription']=Yii::app()->params['siteDescription'];
		$this->page['mainUrl']='map';
		$this->page['title']='Поиск и карта сайта';
		
		$this->page['links']=Section::model()->treeMapList();
		
		$this->render('map');
	}
	
	
	public function actionSearch()
	{
		if(!empty($_POST['search']))
		{	
			Params::model()->setSiteParams();
					
			$this->page['metaTitle']='Поиск по сайту';
			$this->page['metaKeywords']=Yii::app()->params['siteKeywords'];
			$this->page['metaDescription']=Yii::app()->params['siteDescription'];
			$this->page['mainUrl']='map';
			$this->page['title']='Результаты поиска';
			
			$cleanSearch = new CHtmlPurifier();
			
			$this->page['searchString'] = $cleanSearch->purify(strip_tags($_POST['search']));
			$this->page['links']=CHtml::listData(Section::model()->getSearchList($this->page['searchString']),'url','name');
			
			$this->render('map');
		}
		else $this->redirect('/map/');
	}
	
	public function actionSendmail()
	{
		if(empty($_POST))
		{
			$this->redirect('/map/');
			Yii::app()->end();
		}
		
		if(Yii::app()->controller->createAction('captcha')->verifyCode!=$_POST['captcha'])
		{
			echo "<script>alert('Неверный код подтверждения');history.go(-1);</script>";
			Yii::app()->end();
		}
		
		
		$subject = "Письмо с сайта webelement.ru";
		
		if($_POST['formtype']=='regular')
		{
			
			$message = '
				<html>
				<head>
				 <title>'.$subject.'</title>
				</head>
				<body>
				<p>Имя: '.$_POST['name'].'</p>
				<p>Телефон: '.$_POST['phone'].'</p>
				<p>В какое время перезвонить: '.$_POST['time'].'</p>
				<p>Страница: '.$_POST['cur_page'].'</p>
				<p>ОС: '.$_POST['os'].'</p>
				<p>Браузер: '.$_POST['browser'].'</p>
				</body>
				</html>
				';
				
		}
		elseif($_POST['formtype']=='contacts')
		{
			
			$str = "";
			for($i=0; $i<7; $i++) {
				if(!empty($_POST['chk_grp'][$i]))
					$str .= $_POST['chk_grp'][$i]."<br />";
			}
			$message = '
			<html>
			<head>
			 <title>'.$subject.'</title>
			</head>
			<body>
			<p>Имя: '.$_POST['name'].'</p>
			<p>Телефон: '.$_POST['phone'].'</p>
			<p>email: '.$_POST['email'].'</p>
			<p>Компания: '.$_POST['company_name'].'</p>
			<p>Дополнительная информация: <br />'.$_POST['message'].'</p>
			<p>Что нужно: <br />'.$str.'</p>
			<p>Страница: '.$_POST['cur_page'].'</p>
			<p>ОС: '.$_POST['os'].'</p>
			<p>Браузер: '.$_POST['browser'].'</p>
			</body>
			</html>
			';
			
		}
		elseif($_POST['formtype']=='mainpage')
		{
			$message = '
			<html>
			<head>
			<title>Ололо вам письмо</title>
			</head>
			<body>
			<p>Имя: '.$_POST['name'].'</p>
			<p>Телефон: '.$_POST['phone'].'</p>
			<p>email: '.$_POST['email'].'</p>
			<p>Текст сообщения: <br />'.$_POST['message'].'</p>
			<p>Страница: '.$_POST['cur_page'].'</p>
			<p>ОС: '.$_POST['os'].'</p>
			<p>Браузер: '.$_POST['browser'].'</p>
			</body>
			</html>
			';
			
		}
		
		$to= "<".Yii::app()->params->adminEmail.">" ;//. ", " ; //обратите внимание на запятую
		//$to .= "<zhuk@host-kmv.ru>";

		//$to= "<maxcorp21@gmail.com>";

		$headers= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: webelement.ru <info@webelement.ru>\r\n";
		
		//echo $message;die();

		mail($to, $subject, $message, $headers);
		

		$model=Block::model()->findByPk(11);	
		
		Params::model()->setSiteParams();
			
		$this->page['metaTitle']='Ваше письмо отправлено';
		$this->page['metaKeywords']=Yii::app()->params['siteKeywords'];
		$this->page['metaDescription']=Yii::app()->params['siteDescription'];
		$this->page['mainUrl']='sendmail';
		$this->page['title']=$model->name;
		
		$this->render('innerpage',array('model'=>$model));
	}
	
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->layout='//layouts/adminLogin';
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
