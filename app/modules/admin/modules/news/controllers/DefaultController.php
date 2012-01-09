<?php

class DefaultController extends AController
{
	
	public function actionIndex()
	{
		$this->pageTitle = 'Новости';
		$this->breadcrumbs = array($this->pageTitle);
		
		$model=new News('search');
		$model->unsetAttributes();
		$this->render('index', array('model' => $model));
	}
	
	
	
	public function actionCreate()// Добавить
	{

		$model = new News;

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['News']))
		{
			$model->attributes = $_POST['News'];
			$model->short = $_POST['News']['short'];
			$model->date = $_POST['News']['date'].' '.date('h:i:s');
			$model->save();
			
			$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить запись';
		$this->breadcrumbs = array(
			'Новости' => array('index'),
			$this->pageTitle
		);
		
		
		$list['pid'] = Section::model()->treeList();
		$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
		
		$this->render('create',array(
			'model' => $model,
			'list' => $list,
			'images'=>false
		));
					
	}
	
	public function actionEdit($id)
	{

		$model=News::model()->findByPk($id);

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['News']))
		{
			
			//аплоад картинок в который передается $model->id, название текущей модели и $_POST
			Images::model()->upload($model->id,get_class($model),$_POST);
			
			$model->attributes=$_POST['News'];
			$model->short=$_POST['News']['short'];
			$model->date = $_POST['News']['date'].' '.date('h:i:s');
			if($model->save())
				$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$id:''));
		}
		
		$this->pageTitle = 'Редактировать запись'.' # '.$model->id;
		$this->breadcrumbs = array(
			'Новости' => array('index'),
			'Редактировать запись',
		);
		$list['pid'] = Section::model()->treeList();
		$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
		
		$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)));

		$this->render('create',array(
			'model' => $model,
			'list' => $list,
			'images' => $images,
		));
					
	}
	
	public function actionDelete($id)
	{
		Images::model()->deleteImage($id,'News');
		News::model()->deleteByPk($id);
		echo "<script>alert('Запись #{$id} удалена.');document.location='/".$this->module->id."';</script>";		
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
