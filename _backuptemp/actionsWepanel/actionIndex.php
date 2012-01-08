<?php
class actionIndex extends CAction {

	public function run()
	{
		if(Yii::app()->user->isGuest) 
			$this->controller->redirect(Yii::app()->user->loginUrl);
		else $this->controller->render("index");
	}
	

	
}
