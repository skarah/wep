<?php

/**
 * This is the model class for table "WE_news".
 *
 * The followings are the available columns in table 'WE_news':
 * @property integer $id
 * @property integer $section
 * @property integer $mark
 * @property string $name
 * @property string $short
 * @property string $content
 * @property string $date
 */
class News extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return News the static model class
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
		return 'WE_news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, date', 'required','message' => 'Поле не может быть пустым.'),
			array('section, mark', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, section, mark, name, short, content, date', 'safe', 'on'=>'search'),
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
		//'sect'=>array(self::BELONGS_TO, 'Tag', 'section'),
		//	'tags'=>array(self::MANY_MANY, 'Tag','WE_news_tag(nid, tid)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'section' => 'В раздел',
			'mark' => 'Выделить',
			'name' => 'Заголовок',
			'short' => 'Аннотация',
			'content' => 'Текст',
			'date' => 'Дата',
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
		$criteria->compare('section',$this->section);
		$criteria->compare('mark',$this->mark);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('short',$this->short,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}
