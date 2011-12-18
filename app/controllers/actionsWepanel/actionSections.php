<?php
class actionSections extends CAction {

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
					// Добавить раздел//////////////////////////////////
					case 'create': 
					$model = new Section;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Section']))
					{
						$model->attributes = $_POST['Section'];
						if($model->save())
							$this->controller->redirect('/wepanel'.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/'.Yii::app()->controller->action->id.'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Добавить раздел',
					);
					$this->controller->pageTitle = 'Добавить раздел';
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
					
					$this->controller->render('//wepanel/section/create',array(
						'model' => $model,
						'list' => $list,
						'pid' => $pid,
						'purl' => $purl,
						'images' => false,
					));
					break;
					//--------------------------------------------------
					
					// Редактировать раздел ----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Section::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

						if(isset($_POST['Section']))
						{
							//аплоад картинок в который передается $model->id, название текущей модели и $_POST
							Images::model()->upload($model->id,get_class($model),$_POST);
							
							$model->attributes=$_POST['Section'];
							if($model->save())
								$this->controller->redirect('/wepanel'.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/'.Yii::app()->controller->action->id.'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Редактировать раздел',
						);
						$this->controller->pageTitle = 'Редактировать раздел'.' # '.$model->id;
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
						$this->controller->render('//wepanel/section/create',array(
							'model' => $model,
							'list' => $list,
							'pid' => $pid,
							'purl' => $purl,
							'images' => $images,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить раздел с подразделами (Аякс запрос) -----
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						// рекурсивное удаление
						if(Section::model()->treeDelete($_GET['item']))
							echo "<script>alert('Раздел #{$_GET['item']} и все его подразделы удалены.');document.location='/wepanel';</script>";
						else 
							echo "<script>alert('Ошибка при удалении раздела #{$_GET['item']}.');</script>";
					}
					
					break;
					//--------------------------------------------------
				}
				
			}
			else
			{
				$this->controller->redirect('/wepanel');
			}
		}
	}
	
}
