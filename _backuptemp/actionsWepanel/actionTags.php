<?php
class actionTags extends CAction {

	public function run()
	{
		if(Yii::app()->user->isGuest) 
			$this->controller->redirect(Yii::app()->user->loginUrl);
		else
		{
			if(!empty($_GET['act']))
			{
				switch ($_GET['act'])
				{
					// Добавить Тег ////////////////////////////////
					case 'create': 
					$model = new Tag;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Tag']))
					{
						$model->attributes = $_POST['Tag'];
						if($model->save())
							$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Теги' => array('tags'),
						'Добавить тег',
					);
					$this->controller->pageTitle = 'Добавить тег';
					$list['pid'] = Section::model()->treeList();
					$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
					
					$this->controller->render('//wepanel/tags/create',array(
						'model' => $model,
						'list' => $list,
					));
					break;
					//--------------------------------------------------
					
					// Редактировать тег ----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Tag::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

						if(isset($_POST['Tag']))
						{
							$model->attributes=$_POST['Tag'];
							if($model->save())
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Теги' => array('tags'),
							'Редактировать тег',
						);
						$this->controller->pageTitle = 'Редактировать тег'.' # '.$model->id;
						$list['pid'] = Section::model()->treeList();
						$list['type'] = CHtml::listData(Type::model()->findAll(array('order' => 'id')), 'id', 'name');
						
						$this->controller->render('//wepanel/tags/create',array(
							'model' => $model,
							'list' => $list,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить тег ---------------------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Tag::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}					
					break;
					//--------------------------------------------------
						
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Теги');
				$this->controller->pageTitle = 'Теги';
				
				$model=new Tag('search');
				$model->unsetAttributes();  // clear any defa
				if(empty($model)) $sendToView=array('model' => $model);
				$this->controller->render('//wepanel/tags/index', array('model' => $model));
			}
		}
	}
	
}
