<?php
// модель отвечающая за связи тегов с новостями
class NewsTags extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'WE_news_tag';
	}

	
}
