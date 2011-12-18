<?php
class actionNews extends CAction {

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
					// Добавить Новость ////////////////////////////////
					case 'create': 
					$model = new News;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

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
						
						$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Журнал' => array('news'),
						'Добавить запись',
					);
					$this->controller->pageTitle = 'Добавить запись';
					
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
					
					$this->controller->render('//wepanel/news/create',array(
						'model' => $model,
						'list' => $list,
						'pid' => $pid,
						'purl' => $purl,
						'images'=>false
					));
					break;
					//--------------------------------------------------
					
					// Редактировать новость ----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=News::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

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
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Журнал' => array('news'),
							'Редактировать запись',
						);
						$this->controller->pageTitle = 'Редактировать запись'.' # '.$model->id;
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
	
						$this->controller->render('//wepanel/news/create',array(
							'model' => $model,
							'list' => $list,
							'pid' => $pid,
							'images' => $images,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить новость ---------------------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Images::model()->deleteImage($_GET['item'],'News');
						News::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}
					break;
					//--------------------------------------------------
					
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Журнал');
				$this->controller->pageTitle = 'Журнал';
				
				$model=new News('search');
				$model->unsetAttributes();  // clear any defa
				$this->controller->render('//wepanel/news/index', array('model' => $model));
			}
		}
	}
	
}
