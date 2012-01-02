<?php

class GalleryController extends AController
{
	
	public function actionIndex()
	{
		$this->pageTitle = 'Галереи';
		$this->breadcrumbs = array($this->pageTitle);
		
		$model=new Gallery('search');
		$model->unsetAttributes();  // clear any defa
		$this->render('index', array('model' => $model));
	}
	
	
	
	public function actionCreate()// Добавить раздел
	{

		$model = new Gallery;

		// проверка формы аяксом
		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['Gallery']))
		{
			$model->attributes = $_POST['Gallery'];
			if($model->save())
				$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить галерею';
		$this->breadcrumbs = array(
			'Галереи' => array('gallery'),
			$this->pageTitle
		);
		
		
		$this->render('create',array(
			'model' => $model,
			'images' => false,
		));

	}
	
	public function actionEdit()
	{
		
		if(!empty($_GET['item']))
		{
			$model=Gallery::model()->findByPk($_GET['item']);

			// проверка формы аяксом
			if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			if(isset($_POST['Gallery']))
			{
				//аплоад картинок в который передается $model->id, название текущей модели и $_POST
				Images::model()->upload($model->id,get_class($model),$_POST);
											
				$model->attributes=$_POST['Gallery'];
				if($model->save())
					$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$_GET['item']:''));
			}
			
			$this->pageTitle = 'Редактировать галерею'.' # '.$model->id;
			$this->breadcrumbs = array(
				'Галереи' => array('galleries'),
				'Редактировать галерею',
			);
			
			$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)),array('order'=>'posled, id'));
			$this->render('create',array(
				'model' => $model,
				'images' => $images,
			));
		}
		
	}
	
	public function actionDelete()
	{
	
		if(!empty($_GET['item']))
		{
			Images::model()->deleteImage($_GET['item'],'Gallery');
			Gallery::model()->deleteByPk($_GET['item']);
			echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/".$this->module->id.(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
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
