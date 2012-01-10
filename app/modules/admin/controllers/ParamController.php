<?php

class ParamController extends AController
{
	
	public function actionIndex()
	{
		$this->pageTitle = 'Настройки';
		$this->breadcrumbs = array($this->pageTitle);
		
		$model=new Params('search');
		$model->unsetAttributes();  // clear any defa
		$this->render('index', array('model' => $model));
	}
	
	
	
	public function actionCreate()// Добавить раздел
	{

		$model = new Params;

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='param-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Params']))
		{
			$model->attributes = $_POST['Params'];
			if($model->save())
				$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить запись в настройки';
		$this->breadcrumbs = array(
			'Настройки' => array('/admin/param'),
			$this->pageTitle
		);
		
		$this->render('create',array(
			'model' => $model,
		));
		
	}
	
	public function actionEdit($id)
	{
		$model=Params::model()->findByPk($id);

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='param-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Params']))
		{							
			$model->attributes=$_POST['Params'];
			if($model->save())
				$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/'.$id:''));
		}

		$this->pageTitle = 'Редактировать запись в настройках'.' # '.$model->id;			
		$this->breadcrumbs = array(
			'Настройки' => array('/admin/param'),
			'Редактировать запись в настройках',
		);
		
		$this->render('create',array(
			'model' => $model,
		));		
	}
	
	public function actionDelete($id)
	{
		Params::model()->deleteByPk($id);
		echo "<script>alert('Запись #{$id} удалена.');document.location='/".$this->module->id.(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
	}
	
}
