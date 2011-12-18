<?php
class actionGuestbook extends CAction {

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
					// Добавить Отзыв ////////////////////////////////
					case 'create': 
					$model = new Guestbook;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Guestbook']))
					{
						$model->attributes = $_POST['Guestbook'];
						$model->content = $_POST['Guestbook']['content'];
						if($model->save())
							$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Отзывы' => array('guestbook'),
						'Добавить отзыв',
					);
					$this->controller->pageTitle = 'Добавить отзыв';
					
					$this->controller->render('//wepanel/guestbook/create',array(
						'model' => $model,
					));
					break;
					//--------------------------------------------------
					
					// Редактировать отзыв ----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Guestbook::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

						if(isset($_POST['Guestbook']))
						{
							$model->attributes=$_POST['Guestbook'];
							$model->content = $_POST['Guestbook']['content'];
							if($model->save())
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Отзывы' => array('guestbook'),
							'Редактировать отзыв',
						);
						$this->controller->pageTitle = 'Редактировать отзыв'.' # '.$model->id;
						
						$this->controller->render('//wepanel/guestbook/create',array(
							'model' => $model,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить отзыв ---------------------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Guestbook::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}
					break;
					//--------------------------------------------------
						
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Отзывы');
				$this->controller->pageTitle = 'Отзывы';
				
				$model=new Guestbook('search');
				$model->unsetAttributes();  // clear any defa
				$this->controller->render('//wepanel/guestbook/index', array('model' => $model));
			}
		}
	}
	
}
