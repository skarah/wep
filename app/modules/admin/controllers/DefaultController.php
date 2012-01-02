<?php

class DefaultController extends AController
{
	
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionLogin()
	{
		$model=new AdminLoginForm;

		// если проверка формы осущетвляется аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// получаем данные от юзера
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes=$_POST['AdminLoginForm'];
			// проверяем введенную инфу и редиректим на главную админки
			if($model->validate() && $model->login())
			{
				$_SESSION['ckfinder'] = true;
				$this->redirect('/admin');
			}
				//$this->redirect(Yii::app()->user->returnUrl);
		}
		// показываем логин форму
		$this->pageTitle=Yii::app()->name . ' - Login';
		$this->layout=false;// без лэйаута
		$this->render('AdminLoginForm',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		unset($_SESSION['ckfinder']);
		$this->redirect('/admin');
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
	
}
