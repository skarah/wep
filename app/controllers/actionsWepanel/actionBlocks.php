<?php
class actionBlocks extends CAction {

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
					// Добавить блок//////////////////////////////////
					case 'create': 
					$model = new Block;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Block']))
					{
						$model->attributes = $_POST['Block'];
						if($model->save())
							$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Блоки' => array('blocks'),
						'Добавить блок',
					);
					$this->controller->pageTitle = 'Добавить блок';
					
					
					$this->controller->render('//wepanel/blocks/create',array(
						'model' => $model,
						'images' => false,
					));
					break;
					//--------------------------------------------------
					
					// Редактировать блок ----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Block::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

						if(isset($_POST['Block']))
						{
							//аплоад картинок в который передается $model->id, название текущей модели и $_POST
							Images::model()->upload($model->id,get_class($model),$_POST);
														
							$model->attributes=$_POST['Block'];
							if($model->save())
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Блоки' => array('blocks'),
							'Редактировать блок',
						);
						$this->controller->pageTitle = 'Редактировать блок'.' # '.$model->id;
						
						$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)));
						$this->controller->render('//wepanel/blocks/create',array(
							'model' => $model,
							'images' => $images,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить блок ---------------------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Images::model()->deleteImage($_GET['item'],'Block');
						Block::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}
					break;
					//--------------------------------------------------
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Блоки');
				$this->controller->pageTitle = 'Блоки';
				
				$model=new Block('search');
				$model->unsetAttributes();  // clear any defa
				$this->controller->render('//wepanel/blocks/index', array('model' => $model));
			}
		}
	}
	
}
