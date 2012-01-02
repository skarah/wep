<?
Yii::import('zii.widgets.CPortlet');
 
class EditorAddons extends CPortlet
{
	public $snippetList;
	public $galleriesList;
	public $modelName;
    public function init()
    {
        parent::init();
    }
 
    protected function renderContent()
    {
		$this->snippetList=Snippet::model()->findAll();
		$this->galleriesList=Gallery::model()->findAll();
        $this->render('EditorAddons', array('snippetList'=>$this->snippetList, 'galleriesList'=>$this->galleriesList, 'modelName'=>$this->modelName));
    }
}
