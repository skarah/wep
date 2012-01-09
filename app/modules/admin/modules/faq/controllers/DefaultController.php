<?php

class DefaultController extends AController
{
	
	public function actionIndex()
	{
		$this->pageTitle = 'FAQ';
		$this->breadcrumbs = array($this->pageTitle);
		
		$model=new Faq('search');
		$model->unsetAttributes();
		$this->render('index', array('model' => $model));
	}
	
	
	
	public function actionCreate()// Добавить
	{

		$model = new Faq;

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='faq-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Faq']))
		{
			$model->attributes = $_POST['Faq'];
			$model->question = $_POST['Faq']['question'];
			$model->answer = $_POST['Faq']['answer'];
			$model->save();
			
			$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить запись';
		$this->breadcrumbs = array(
			'FAQ' => array('index'),
			$this->pageTitle
		);
		
		$list['pid'] = Section::model()->treeList();
		$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
		
		$this->render('create',array(
			'model' => $model,
			'list' => $list,
		));
					
	}
	
	public function actionEdit($id)
	{
		
		$model=Faq::model()->findByPk($id);

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='faq-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Faq']))
		{				
			
			$model->attributes = $_POST['Faq'];
			$model->question = $_POST['Faq']['question'];
			$model->answer = $_POST['Faq']['answer'];
			if($model->save())
				$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/'.$id:''));
		}
		
		$this->pageTitle = 'Редактировать запись'.' # '.$model->id;
		$this->breadcrumbs = array(
			'FAQ' => array('index'),
			'Редактировать запись',
		);
		$list['pid'] = Section::model()->treeList();
		$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
		
		$this->render('create',array(
			'model' => $model,
			'list' => $list,
		));
		
	}
	
	public function actionDelete($id)
	{
		Faq::model()->deleteByPk($id);
		echo "<script>alert('Запись #{$id} удалена.');document.location='/".$this->module->id."';</script>";
		
	}

	
}
