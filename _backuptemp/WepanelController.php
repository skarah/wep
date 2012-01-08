<?php

class WepanelController extends WeController
{
	public function actions()
	{
		return array
		(
			'index' => 'application.controllers.actionsWepanel.actionIndex',
			'params' => 'application.controllers.actionsWepanel.actionParams',
			'sections' => 'application.controllers.actionsWepanel.actionSections',
			'blocks' => 'application.controllers.actionsWepanel.actionBlocks',
			'news' => 'application.controllers.actionsWepanel.actionNews',
			'galleries' => 'application.controllers.actionsWepanel.actionGalleries',
			'portfolio' => 'application.controllers.actionsWepanel.actionPortfolio',
			'tags' => 'application.controllers.actionsWepanel.actionTags',
			'guestbook' => 'application.controllers.actionsWepanel.actionGuestbook',
			'banners' => 'application.controllers.actionsWepanel.actionBanners',
			'snippets' => 'application.controllers.actionsWepanel.actionSnippets',
		);
	}
	
	public function actionLogin()
	{
		$model=new AdminLoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes=$_POST['AdminLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$_SESSION['ckfinder'] = true;
				$this->redirect('/wepanel');
			}
				//$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->layout='//wepanel/_adminLogin';
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		unset($_SESSION['ckfinder']);
		$this->redirect('/wepanel');
	}    
    
    public function actionDeleteimage()
    {
		if(!Yii::app()->user->isGuest)
		{
			if(!empty($_GET['item']))
			{
				$image=Images::model()->findByPk($_GET['item']);
				unlink(Yii::getPathOfAlias('webroot').'/content/'.$image->file);
				if(is_file(Yii::getPathOfAlias('webroot').Yii::app()->params['thumbDir'].Yii::app()->params['thumbPrefix'].$image->file))
					unlink(Yii::getPathOfAlias('webroot').Yii::app()->params['thumbDir'].Yii::app()->params['thumbPrefix'].$image->file);
				Images::model()->deleteByPk($_GET['item']);
				echo "<script>$('#imgs{$_GET['item']}').remove();</script>";
			}
		}
		else $this->redirect(Yii::app()->user->loginUrl);
	}
	
	public function actionUpdateimage()
	{
		if(!Yii::app()->user->isGuest)
		{
			if(!empty($_GET['item']))
			{
				if(empty($_GET['posled'])) Images::model()->updateByPk($_GET['item'],array('name'=>$_GET['name']));
				else Images::model()->updateByPk($_GET['item'],array('name'=>$_GET['name'],'posled'=>$_GET['posled']));
				echo "<script>alert('Информация об изображении сохранена.');</script>";
			}
		}
	}
    
	public function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionError()
    {
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->renderPartial('error', array('error'=>$error));
		}
    }		
       /*    
    public function beforeAction($action)
    { // доработать запись логов действий администратора

        $logString = '';
        $logString = Yii::app()->user->name .';'.CHttpRequest::getUserHostAddress(). ';' . $this->id. ';' . $action->id ;
        echo $logString;

        return true;
    }*/
		
}
