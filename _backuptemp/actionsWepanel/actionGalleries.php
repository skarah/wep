<?php
class actionGalleries extends CAction {

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
					// Добавить галерею/////////////////////////////////
					case 'create': 
					$model = new Gallery;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Gallery']))
					{
						$model->attributes = $_POST['Gallery'];
						if($model->save())
							$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Галереи' => array('galleries'),
						'Добавить галерею',
					);
					$this->controller->pageTitle = 'Добавить галерею';
					
					
					$this->controller->render('//wepanel/galleries/create',array(
						'model' => $model,
						'images' => false,
					));
					break;
					//--------------------------------------------------
					
					// Редактировать галерею----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Gallery::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

						if(isset($_POST['Gallery']))
						{
							//аплоад картинок в который передается $model->id, название текущей модели и $_POST
							Images::model()->upload($model->id,get_class($model),$_POST);
														
							$model->attributes=$_POST['Gallery'];
							if($model->save())
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Галереи' => array('galleries'),
							'Редактировать галерею',
						);
						$this->controller->pageTitle = 'Редактировать галерею'.' # '.$model->id;
						
						$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)),array('order'=>'posled, id'));
						$this->controller->render('//wepanel/galleries/create',array(
							'model' => $model,
							'images' => $images,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить галерею ---------------------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Images::model()->deleteImage($_GET['item'],'Gallery');
						Gallery::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}
					break;
					//--------------------------------------------------
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Галереи');
				$this->controller->pageTitle = 'Галереи';
				
				$model=new Gallery('search');
				$model->unsetAttributes();  // clear any defa
				$this->controller->render('//wepanel/galleries/index', array('model' => $model));
			}
		}
	}
	
}

