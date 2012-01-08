<?php
class actionParams extends CAction {

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
					// Добавить запись в настройки /////////////////////
					case 'create': 
					$model = new Params;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Params']))
					{
						$model->attributes = $_POST['Params'];
						if($model->save())
							$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Настройки' => array('params'),
						'Добавить запись в настройки',
					);
					$this->controller->pageTitle = 'Добавить запись в настройки';
					
					$this->controller->render('//wepanel/params/create',array(
						'model' => $model,
					));
					break;
					//--------------------------------------------------
					
					// Редактировать запись в настройках ---------------	
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Params::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);

						if(isset($_POST['Params']))
						{							
							$model->attributes=$_POST['Params'];
							if($model->save())
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Настройки' => array('params'),
							'Редактировать запись в настройках',
						);
						$this->controller->pageTitle = 'Редактировать запись в настройках'.' # '.$model->id;
						
						$this->controller->render('//wepanel/params/create',array(
							'model' => $model,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить запись из настроек ----------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Params::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}
					break;
					//--------------------------------------------------
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Настройки');
				$this->controller->pageTitle = 'Настройки';
				
				$model=new Params('search');
				$model->unsetAttributes();  // clear any defa
				$this->controller->render('//wepanel/params/index', array('model' => $model));
			}
		}
	}
	
}
