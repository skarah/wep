<?php

/**
 * This is the model class for table "WE_portfolio".
 *
 * The followings are the available columns in table 'WE_portfolio':
 * @property integer $id
 * @property integer $mark
 * @property string $name
 * @property string $client
 * @property string $site
 * @property string $task
 * @property string $before_text
 * @property string $after_text
 */
class Portfolio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Portfolio the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'WE_portfolio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, client, site, date, task', 'required'),
			array('mark', 'numerical', 'integerOnly'=>true),
			array('name, client, site', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mark, name, client, site, date, task, before_text, after_text', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mark' => 'На главную',
			'name' => 'Название',
			'client' => 'Заказчик',
			'site' => 'Сайт',
			'date' => 'Дата',
			'task' => 'Задача',
			'before_text' => 'Текст до скриншотов',
			'after_text' => 'Текст после скриншотов',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('mark',$this->mark);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('client',$this->client,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('task',$this->task,true);
		$criteria->compare('before_text',$this->before_text,true);
		$criteria->compare('after_text',$this->after_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getTagList($sectionId=32,$portfolioId=false)
	{
		if(!empty($portfolioId))
		{
						
			return CHtml::listData(Yii::app()->db->createCommand()
				->select('WE_tag.alias, WE_tag.name')
				->from('WE_portfolio')
				->join('WE_portfolio_tag', 'WE_portfolio_tag.pid=WE_portfolio.id')
				->join('WE_tag', 'WE_tag.id=WE_portfolio_tag.tid')//.$portfolioId)
				->where('WE_portfolio.id=:id', array(':id'=>$portfolioId))
				->query(), 'alias', 'name');
		}
		else
		{
			$try=Tag::model()->findAllByAttributes(array('section'=>$sectionId));
			$model=array();
			for($i=0;$i<sizeof($try);$i++)
			{
				if(PortfolioTags::model()->countByAttributes(array('tid'=>$try[$i]['id']))>0)
					$model[$try[$i]['alias']]=$try[$i]['name'];
			}
			//print_r($model);die();
			return $model;//CHtml::listData(Tag::model()->findAllByAttributes(array('section'=>$sectionId)), 'alias', 'name');
		}
	}
}
