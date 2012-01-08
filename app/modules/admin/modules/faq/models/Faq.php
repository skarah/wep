<?php

/**
 * This is the model class for table "WE_faq".
 *
 * The followings are the available columns in table 'WE_faq':
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property integer $posled
 */
class Faq extends CActiveRecord
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
		return 'WE_faq';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question, answer', 'required','message' => 'Поле не может быть пустым.'),
			array('posled', 'numerical', 'integerOnly'=>true),
			array('id, question, answer, posled', 'safe', 'on'=>'search'),
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
			'question' => 'Вопрос',
			'answer' => 'Ответ',
			'posled' => 'Порядок',
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
		$criteria->compare('question',$this->question,true);
		$criteria->compare('answer',$this->answer,true);
		$criteria->compare('posled',$this->posled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
		
}
