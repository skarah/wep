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
				$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить запись в настройки';
		$this->breadcrumbs = array(
			'Настройки' => array('params'),
			$this->pageTitle
		);
		
		$this->render('create',array(
			'model' => $model,
		));
		
	}
	
	public function actionEdit()
	{
		
		if(!empty($_GET['item']))
		{
			$model=Params::model()->findByPk($_GET['item']);

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
					$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$_GET['item']:''));
			}

			$this->pageTitle = 'Редактировать запись в настройках'.' # '.$model->id;			
			$this->breadcrumbs = array(
				'Настройки' => array('params'),
				'Редактировать запись в настройках',
			);
			
			$this->render('//wepanel/params/create',array(
				'model' => $model,
			));
		}
		
	}
	
	public function actionDelete()
	{
		
		if(!empty($_GET['item']))
		{
			Params::model()->deleteByPk($_GET['item']);
			echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/".$this->module->id.(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
		}
		
	}
	
}
