<?php

class BlockController extends AController
{
	
	public function actionIndex()
	{
		$this->pageTitle = 'Блоки';
		$this->breadcrumbs = array($this->pageTitle);
		
		$model=new Block('search');
		$model->unsetAttributes();  
		$this->render('index', array('model' => $model));
	}
	
	
	
	public function actionCreate()// Добавить раздел
	{

		$model = new Block;

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='block-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Block']))
		{
			$model->attributes = $_POST['Block'];
			if($model->save())
				$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить блок';

		$this->breadcrumbs = array(
			'Блоки' => array('block'),
			$this->pageTitle
		);
		
		
		$this->render('create',array(
			'model' => $model,
			'images' => false,
		));
		
	}
	
	public function actionEdit($id)
	{
		
		$model=Block::model()->findByPk($id);

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='block-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Block']))
		{
			//аплоад картинок в который передается $model->id, название текущей модели и $_POST
			Images::model()->upload($model->id,get_class($model),$_POST);
										
			$model->attributes=$_POST['Block'];
			if($model->save())
				$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/'.$id:''));
		}
		
		$this->pageTitle = 'Редактировать блок'.' # '.$model->id;
		$this->breadcrumbs = array(
			'Блоки' => array('block'),
			'Редактировать блок',
		);
		
		$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)));
		$this->render('create',array(
			'model' => $model,
			'images' => $images,
		));
		
	}
	
	public function actionDelete($id)
	{
			Images::model()->deleteImage($id,'Block');
			Block::model()->deleteByPk($id);
			echo "<script>alert('Запись #{$id} удалена.');document.location='/".$this->module->id.(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
	}
	
	// аякс функции для удаления и редактирования изображении к записям
	
    public function actionDeleteimage($id)
    {
		$image=Images::model()->findByPk($id);
		unlink(Yii::getPathOfAlias('webroot').'/content/'.$image->file);
		if(is_file(Yii::getPathOfAlias('webroot').Yii::app()->params['thumbDir'].Yii::app()->params['thumbPrefix'].$image->file))
			unlink(Yii::getPathOfAlias('webroot').Yii::app()->params['thumbDir'].Yii::app()->params['thumbPrefix'].$image->file);
		Images::model()->deleteByPk($id);
		echo "<script>$('#imgs{$id}').remove();</script>";
	}
	
	public function actionUpdateimage($id)
	{
		if(empty($_GET['posled'])) Images::model()->updateByPk($id,array('name'=>$_GET['name']));
		else Images::model()->updateByPk($id,array('name'=>$_GET['name'],'posled'=>$_GET['posled']));
		echo "<script>alert('Информация об изображении сохранена.');</script>";
	}

	
}
