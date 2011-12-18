<?php

/**
 * This is the model class for table "WE_tag".
 *
 * The followings are the available columns in table 'WE_tag':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property integer $section
 */
class Tag extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Tag the static model class
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
		return 'WE_tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, alias, section', 'required','message' => 'Поле не может быть пустым.'),
			array('section', 'numerical', 'integerOnly'=>true),
			array('name, alias', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, alias, section', 'safe', 'on'=>'search'),
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
            //'type'=>array(self::HAS_ONE, 'Section', 'id'),
            'sections'=>array(self::BELONGS_TO, 'Section', 'section'),
            'news'=>array(self::MANY_MANY, 'News','WE_news_tag(tid, nid)'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'alias' => 'Путь',
			'section' => 'Раздел',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('section',$this->section);
		$criteria->compare('sections',$this->sections);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
