<?php
class actionSnippets extends CAction {

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
					// Добавить сниппет//////////////////////////////////
					case 'create': 
					$model = new Snippet;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Snippet']))
					{
						$model->attributes = $_POST['Snippet'];
						if($model->save())
							$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Сниппеты' => array('snippets'),
						'Добавить сниппет',
					);
					$this->controller->pageTitle = 'Добавить сниппет';
					
					
					$this->controller->render('//wepanel/snippets/create',array(
						'model' => $model,
					));
					break;
					//--------------------------------------------------
					
					// Редактировать сниппет ----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Snippet::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

						if(isset($_POST['Snippet']))
						{														
							$model->attributes=$_POST['Snippet'];
							if($model->save())
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Сниппеты' => array('snippets'),
							'Редактировать сниппет',
						);
						$this->controller->pageTitle = 'Редактировать сниппет'.' # '.$model->id;
						
						$this->controller->render('//wepanel/snippets/create',array(
							'model' => $model,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить сниппет ---------------------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Snippet::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}
					break;
					//--------------------------------------------------
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Сниппеты');
				$this->controller->pageTitle = 'Сниппеты';
				
				$model=new Snippet('search');
				$model->unsetAttributes();  // clear any defa
				$this->controller->render('//wepanel/snippets/index', array('model' => $model));
			}
		}
	}
	
}
