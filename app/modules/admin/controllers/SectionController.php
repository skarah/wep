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
				$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/'.Yii::app()->controller->id.'/edit/item/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить раздел';

		$this->breadcrumbs = array(
			$this->pageTitle,
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
			'images' => false,
		));
		
	}
	
	public function actionEdit()
	{
		
		if(!empty($_GET['item']))
		{
			$model=Section::model()->findByPk($_GET['item']);

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
					$this->redirect('/'.$this->module->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/'.Yii::app()->controller->id.'/edit/item/'.$_GET['item']:''));
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
		
	}
	
	public function actionDelete()
	{
		
		if(!empty($_GET['item']))
		{
			// рекурсивное удаление
			if(Section::model()->treeDelete($_GET['item']))
				echo "<script>alert('Раздел #{$_GET['item']} и все его подразделы удалены.');document.location='/".$this->module->id."';</script>";
			else 
				echo "<script>alert('Ошибка при удалении раздела #{$_GET['item']}.');</script>";
		}
		
	}
	
	// аякс функции для удаления и редактирования изображении к записям
	
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

	
}
