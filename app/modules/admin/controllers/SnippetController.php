<?php

class SnippetController extends AController
{
	
	public function actionIndex()
	{
		$this->pageTitle = 'Сниппеты';
		$this->breadcrumbs = array($this->pageTitle);
		
		$model=new Snippet('search');
		$model->unsetAttributes();  // clear any defa
		$this->render('index', array('model' => $model));
	}
	
	
	
	public function actionCreate()// Добавить раздел
	{

		$model = new Snippet;

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='snippet-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Snippet']))
		{
			$model->attributes = $_POST['Snippet'];
			if($model->save())
				$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить сниппет';
		$this->breadcrumbs = array(
			'Сниппеты' => array('/admin/snippet'),
			$this->pageTitle
		);
		
		$this->render('create',array(
			'model' => $model,
		));

	}
	
	public function actionEdit($id)
	{
		$model=Snippet::model()->findByPk($id);

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='snippet-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Snippet']))
		{														
			$model->attributes=$_POST['Snippet'];
			if($model->save())
				$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/'.$id:''));
		}

		$this->pageTitle = 'Редактировать сниппет'.' # '.$model->id;			
		$this->breadcrumbs = array(
			'Сниппеты' => array('/admin/snippet'),
			'Редактировать сниппет',
		);
		
		$this->render('create',array(
			'model' => $model,
		));		
	}
	
	public function actionDelete($id)
	{
		Snippet::model()->deleteByPk($id);
		echo "<script>alert('Запись #{$id} удалена.');document.location='/".$this->module->id.(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
	}

}
