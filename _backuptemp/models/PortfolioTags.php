<?php
// модель отвечающая за связи тегов с портфолио
class PortfolioTags extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'WE_portfolio_tag';
	}

	
}
