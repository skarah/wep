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
			
			$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить запись';
		$this->breadcrumbs = array(
			'FAQ' => array('index'),
			$this->pageTitle
		);
		
		$list['pid'] = Section::model()->treeList();
		$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
		
		if(!empty($_GET['item'])) // если добавляется подраздел
		{
			$pid = $_GET['item'];
			$purl = Section::model()->treeUrl($_GET['item']).'/';
		}
		else
		{
			$pid = 0;
			$purl = false;
		}
		
		$this->render('create',array(
			'model' => $model,
			'list' => $list,
			'pid' => $pid,
			'purl' => $purl,
		));
					
	}
	
	public function actionEdit()
	{
		
		if(!empty($_GET['item']))
		{
			$model=Faq::model()->findByPk($_GET['item']);

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
					$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$_GET['item']:''));
			}
			
			$this->pageTitle = 'Редактировать запись'.' # '.$model->id;
			$this->breadcrumbs = array(
				'FAQ' => array('index'),
				'Редактировать запись',
			);
			$list['pid'] = Section::model()->treeList();
			$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
			
			if(!empty($model->pid)) // если редактируется подраздел
			{
				$pid = $model->pid;
			}
			else
			{
				$pid = 0;
			}
			
			$this->render('create',array(
				'model' => $model,
				'list' => $list,
				'pid' => $pid,
			));
		}
		
	}
	
	public function actionDelete()
	{
		
		if(!empty($_GET['item']))
		{
			Faq::model()->deleteByPk($_GET['item']);
			echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/".$this->module->id."';</script>";
		}
		
	}

	
}
