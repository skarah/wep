<?php

/**
 * This is the model class for table "WE_block".
 *
 * The followings are the available columns in table 'WE_block':
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property integer $vis
 */
class Block extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Block the static model class
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
		return 'WE_block';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, content', 'required','message' => 'Поле не может быть пустым.'),
			array('vis', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, content, vis', 'safe', 'on'=>'search'),
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
			'name' => 'Название',
			'content' => 'Текст',
			'vis' => 'Отображать',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('vis',$this->vis);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function afterFind()
	{
		if(Yii::app()->controller->id!='wepanel')
		{			
			preg_match("/<img(.*?)id=\"gallery(.*?)\"(.*?)\/>/is", $this->content, $matches);
			if(!empty($matches[2]))
			{
				$gallery=Yii::app()->controller->widget('InnerGallery',array('galleryId'=>$matches[2]),true);
				$this->content=preg_replace("/<img(.*?)id=\"gallery".$matches[2]."\"(.*?)\/>/is", $gallery, $this->content);
			}
		}
		parent::afterFind();
	} 
	
}
