<?php

class SectionController extends AController
{
	
	public function actionCreate()// Добавить раздел
	{

		$model = new Section;

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='section-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Section']))
		{
			$model->attributes = $_POST['Section'];
			if($model->save())
				$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/'.Yii::app()->controller->id.'/edit/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить раздел';

		$this->breadcrumbs = array(
			$this->pageTitle,
		);
		
		$list['pid'] = Section::model()->treeList();
		$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
		

		if(!empty($_GET['id'])) // если добавляется подраздел
		{
			$pid = $_GET['id'];
			$purl = Section::model()->treeUrl($_GET['id']).'/';
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
			'images' => false,
		));
		
	}
	
	public function actionEdit($id)
	{
		$model=Section::model()->findByPk($id);

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='section-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Section']))
		{
			//аплоад картинок в который передается $model->id, название текущей модели и $_POST
			Images::model()->upload($model->id,get_class($model),$_POST);
			
			$model->attributes=$_POST['Section'];
			if($model->save())
				$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/'.Yii::app()->controller->id.'/edit/'.$id:''));
		}
		
		$this->pageTitle = 'Редактировать раздел'.' # '.$model->id;
		$this->breadcrumbs = array(
			'Редактировать раздел',
		);
		$list['pid'] = Section::model()->treeList();
		$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
		
		if(!empty($model->pid)) // если редактируется подраздел
		{
			$pid = $model->pid;
			$purl = Section::model()->treeUrl($model->pid).'/';
		}
		else
		{
			$pid = 0;
			$purl = false;
		}
		
		$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)));
		$this->render('create',array(
			'model' => $model,
			'list' => $list,
			'pid' => $pid,
			'purl' => $purl,
			'images' => $images,
		));
	}
	
	public function actionDelete($id)
	{
		// рекурсивное удаление
		if(Section::model()->treeDelete($id))
			echo "<script>alert('Раздел #{$id} и все его подразделы удалены.');document.location='/".$this->module->id."';</script>";
		else 
			echo "<script>alert('Ошибка при удалении раздела #{$id}.');</script>";
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
