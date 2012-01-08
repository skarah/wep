<?php

class AController extends CController
{
	public $layout='application.modules.admin.views.layouts.main';
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
			
			//Module::model()->setAdditionalModules();
			return true;
			
        }
    }
	
}
