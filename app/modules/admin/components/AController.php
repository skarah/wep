<?php

class AController extends CController
{
	public $layout='main';
	public $page=array();
	public $menu=array();
	public $breadcrumbs=array();
	
    protected function beforeAction()
    {
		// перед выполнением какого-либо экшена
		// если юзер не залогинен и текущий экшен не login, то редиректим на логин форму
        if(Yii::app()->controller->action->id!='login' && Yii::app()->user->isGuest)
        {
			 $this->redirect(Yii::app()->user->loginUrl);
        } else {
			
			$modules=Module::model()->findAll();
			foreach($modules as $key=>$module)
			{
				if($module->name=='news') 
				{
					Yii::app()->setModules(array($module->name=>array('moduleName'=>'Новости')));
				}
			}
			print_r(Yii::app()->getModules());	
            return true;
        }
    }
	
}
