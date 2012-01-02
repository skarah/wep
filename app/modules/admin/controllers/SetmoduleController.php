<?php

class SetmoduleController extends AController
{
	
	public function actionIndex()
	{
		
		if(isset($_POST['Module']))
		{
			$valid=true;
			foreach($_POST['Module'] as $i=>$item)
			{
				$module=Module::model()->findByAttributes(array('name'=>$item['name']));
				if(empty($module)) $module=new Module;
				
				if(isset($_POST['Module'][$i]))
					$module->attributes=$_POST['Module'][$i];
				$valid=$module->validate() && $valid;
				
				if($valid && isset($_POST['Module'][$i]['show'])) $module->save();
				elseif(!isset($_POST['Module'][$i]['show']) && !empty($module->id)) $module->delete();
			}
			
			$this->redirect('/'.$this->module->id.'/'.Yii::app()->controller->id);
		}
		
		$dir = YiiBase::getPathOfAlias('application.modules.admin.modules');
		$dh  = opendir($dir);
		$allModules = array();
		$i=0;
		while (false !== ($filename = readdir($dh))) 
		{
			  if ($filename != '.' && $filename != '..')
			  {
					 if (is_dir($dir.'/'.$filename))
					 {
						$module=Module::model()->findByAttributes(array('name'=>$filename));
						
						if(!array_key_exists($filename,yii::app()->modules) && empty($module))
						{
							$allModules[$i] = new Module;
							$allModules[$i]->name=$filename;
						}
						else{
							$allModules[$i] = $module;
							}
						$i++;
					 }      
			  }                                             
		}
				
		$this->pageTitle='Используемые модули';
		$this->breadcrumbs=array($this->pageTitle);
		$this->render('index', array('allModules'=>$allModules));

	}

}
