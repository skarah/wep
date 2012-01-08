<?php
class actionBanners extends CAction {

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
					// Добавить Баннер ////////////////////////////////
					case 'create': 
					$model = new Banner;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Banner']))
					{
						$model->attributes = $_POST['Banner'];
						if($model->save())
							$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Баннеры' => array('banners'),
						'Добавить баннер',
					);
					$this->controller->pageTitle = 'Добавить баннер';
					
					$this->controller->render('//wepanel/banners/create',array(
						'model' => $model,
						'images' => array(),
					));
					break;
					//--------------------------------------------------
					
					// Редактировать баннер ----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Banner::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

						if(isset($_POST['Banner']))
						{
							//аплоад картинок в который передается $model->id, название текущей модели и $_POST
							Images::model()->upload($model->id,get_class($model),$_POST);
							
							$model->attributes=$_POST['Banner'];
							if($model->save())
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Баннеры' => array('banners'),
							'Редактировать баннер',
						);
						$this->controller->pageTitle = 'Редактировать баннер'.' # '.$model->id;
						
						
						$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)));
						$this->controller->render('//wepanel/banners/create',array(
							'model' => $model,
							'images' => $images,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить баннер ---------------------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Images::model()->deleteImage($_GET['item'],'Banner');
						Banner::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}
					break;
					//--------------------------------------------------
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Баннеры');
				$this->controller->pageTitle = 'Баннеры';
				
				$model=new Banner('search');
				$model->unsetAttributes();  // clear any defa
				$this->controller->render('//wepanel/banners/index', array('model' => $model));
			}
		}
	}
	
}
