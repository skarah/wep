<?
Yii::import('system.web.widgets.CWidget');
 
class InnerGallery extends CWidget
{
	public $galleryId;
    public function init()
    {
        parent::init();
    }
 
    public function run()
    {
		$images=Images::model()->findAllByAttributes(array('sid'=>$this->galleryId,'model_name'=>'Gallery'),array('order'=>'posled, id'));
        $this->render('InnerGallery', array('images'=>$images));
    }
}
