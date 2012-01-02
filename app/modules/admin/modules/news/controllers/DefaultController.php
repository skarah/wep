<?php

class DefaultController extends AController
{
	
	public function actionIndex()
	{
		echo "ok";die();
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
			
			NewsTags::model()->deleteAllByAttributes(array('nid'=>$model->id));
			if(!empty($_POST['Tag']))
			{
				foreach($_POST['Tag'] as $key=>$tagId)
				{
					if(NewsTags::model()->countByAttributes(array('nid'=>$model->id, 'tid'=>$tagId))==0)
					{
						$newTag = new NewsTags();
						$newTag->nid=$model->id;
						$newTag->tid=$tagId;
						$newTag->save();
						unset($newTag);
					}
				}
			}
			
			$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$model->id:''));
		}

		$this->pageTitle = 'Добавить запись';
		$this->breadcrumbs = array(
			'Новости' => array(Yii::app()->controller->id),
			$this->pageTitle
		);
		
		$list['tag'] = CHtml::listData(Tag::model()->findAll('section=20',array('order' => 'name')), 'id', 'name');
		$list['selected']=array();
		
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
			'images'=>false
		));
					
	}
	
	public function actionEdit()
	{
		
		if(!empty($_GET['item']))
		{
			$model=News::model()->findByPk($_GET['item']);

			// проверка формы аяксом
			if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			if(isset($_POST['News']))
			{
				NewsTags::model()->deleteAllByAttributes(array('nid'=>$model->id));
				if(!empty($_POST['Tag']))
				{
					foreach($_POST['Tag'] as $key=>$tagId)
					{
						if(NewsTags::model()->countByAttributes(array('nid'=>$model->id, 'tid'=>$tagId))==0)
						{
							$newTag = new NewsTags();
							$newTag->nid=$model->id;
							$newTag->tid=$tagId;
							$newTag->save();
							unset($newTag);
						}
					}
				}

				
				//аплоад картинок в который передается $model->id, название текущей модели и $_POST
				Images::model()->upload($model->id,get_class($model),$_POST);
				
				$model->attributes=$_POST['News'];
				$model->short=$_POST['News']['short'];
				$model->date = $_POST['News']['date'].' '.date('h:i:s');
				if($model->save())
					$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/edit/item/'.$_GET['item']:''));
			}
			
			$this->pageTitle = 'Редактировать запись'.' # '.$model->id;
			$this->breadcrumbs = array(
				'Новости' => array(Yii::app()->controller->id),
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

			$list['tag'] = CHtml::listData(Tag::model()->findAll('section=20',array('order' => 'name')), 'id', 'name');
			$list['selected']=CHtml::listData(NewsTags::model()->findAllByAttributes(array('nid'=>$model->id)),'tid','tid');

			$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)));

			$this->render('create',array(
				'model' => $model,
				'list' => $list,
				'pid' => $pid,
				'images' => $images,
			));
		}
		
	}
	
	public function actionDelete()
	{
		
		if(!empty($_GET['item']))
		{
			Images::model()->deleteImage($_GET['item'],'News');
			News::model()->deleteByPk($_GET['item']);
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
