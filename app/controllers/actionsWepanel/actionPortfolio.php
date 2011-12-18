<?php
class actionPortfolio extends CAction {

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
					// Добавить Работу ////////////////////////////////
					case 'create': 
					$model = new Portfolio;

					// Uncomment the following line if AJAX validation is needed
					$this->controller->performAjaxValidation($model);

					if(isset($_POST['Portfolio']))
					{
						$model->attributes = $_POST['Portfolio'];
						$model->task = $_POST['Portfolio']['task'];
						$model->before_text = $_POST['Portfolio']['before_text'];
						$model->after_text = $_POST['Portfolio']['after_text'];
						$model->save();
						
						PortfolioTags::model()->deleteAllByAttributes(array('pid'=>$model->id));
						if(!empty($_POST['Tag']))
						{
							foreach($_POST['Tag'] as $key=>$tagId)
							{
								if(PortfolioTags::model()->countByAttributes(array('pid'=>$model->id, 'tid'=>$tagId))==0)
								{
									$newTag = new PortfolioTags();
									$newTag->pid=$model->id;
									$newTag->tid=$tagId;
									$newTag->save();
									unset($newTag);
								}
							}
						}
						
						$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$model->id:''));
					}

					$this->controller->breadcrumbs = array(
						'Портфолио' => array('portfolio'),
						'Добавить работу',
					);
					$this->controller->pageTitle = 'Добавить работу';
					
					$list['tag'] = CHtml::listData(Tag::model()->findAll('section=32',array('order' => 'name')), 'id', 'name');
					$list['selected']=array();
					
					$this->controller->render('//wepanel/portfolio/create',array(
						'model' => $model,
						'list' => $list,
						'images' =>array(),
					));
					break;
					//--------------------------------------------------
					
					// Редактировать работу ----------------------------		
					case 'edit':
					
					if(!empty($_GET['item']))
					{
						$model=Portfolio::model()->findByPk($_GET['item']);

						// Uncomment the following line if AJAX validation is needed
						$this->controller->performAjaxValidation($model);
						
						if(isset($_POST['Portfolio']))
						{
							PortfolioTags::model()->deleteAllByAttributes(array('pid'=>$model->id));
							if(!empty($_POST['Tag']))
							{
								foreach($_POST['Tag'] as $key=>$tagId)
								{
									if(PortfolioTags::model()->countByAttributes(array('pid'=>$model->id, 'tid'=>$tagId))==0)
									{
										$newTag = new PortfolioTags();
										$newTag->pid=$model->id;
										$newTag->tid=$tagId;
										$newTag->save();
										unset($newTag);
									}
								}
							}
							
							//аплоад картинок в который передается $model->id, название текущей модели и $_POST
							Images::model()->upload($model->id,get_class($model),$_POST);
							
							$model->attributes=$_POST['Portfolio'];
							$model->task = $_POST['Portfolio']['task'];
							$model->before_text = $_POST['Portfolio']['before_text'];
							$model->after_text = $_POST['Portfolio']['after_text'];
							if($model->save())
								$this->controller->redirect('/wepanel/'.Yii::app()->controller->action->id.(!empty($_POST['apply']) && $_POST['apply']=='Применить'?'/act/edit/item/'.$_GET['item']:''));
						}
						
						$this->controller->breadcrumbs = array(
							'Портфолио' => array('portfolio'),
							'Редактировать работу',
						);
						$this->controller->pageTitle = 'Редактировать работу'.' # '.$model->id;
						
						$list['tag'] = CHtml::listData(Tag::model()->findAll('section=32',array('order' => 'name')), 'id', 'name');
						$list['selected']=CHtml::listData(PortfolioTags::model()->findAllByAttributes(array('pid'=>$model->id)),'tid','tid');
						
						//$images = PortfolioImages::model()->findAllByAttributes(array('pid'=>$model->id));
						$images = Images::model()->findAllByAttributes(array('sid'=>$model->id,'model_name'=>get_class($model)));
						$this->controller->render('//wepanel/portfolio/create',array(
							'model' => $model,
							'list' => $list,
							'images' => $images,
						));
					}
					
					break;
					
					//--------------------------------------------------
					
					// Удалить работу ---------------------------------
					case 'delete': 
					
					if(!empty($_GET['item']))
					{
						Images::model()->deleteImage($_GET['item'],'Portfolio');
						Portfolio::model()->deleteByPk($_GET['item']);
						echo "<script>alert('Запись #{$_GET['item']} удалена.');document.location='/wepanel".(!empty($_GET['redirect'])?'/'.$_GET['redirect']:'')."';</script>";
					}
					break;
					//--------------------------------------------------
				}
				
			}
			else
			{
				$this->controller->breadcrumbs = array('Портфолио');
				$this->controller->pageTitle = 'Портфолио';
				
				$model=new Portfolio('search');
				$model->unsetAttributes();  // clear any defa
				$this->controller->render('//wepanel/portfolio/index', array('model' => $model));
			}
		}
	}
	
}
