<?php

/**
 * This is the model class for table "WE_type".
 *
 * The followings are the available columns in table 'WE_type':
 * @property integer $id
 * @property string $name
 */
class Module extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Type the static model class
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
		return 'WE_module';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on'=>'search'),
		);
	}



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Модуль',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function setAdditionalModules()
	{
			$modules=Module::model()->findAll();
			foreach($modules as $key=>$module)
			{
				if($module->name=='news') 
					Yii::app()->setModules(array($module->name=>array('moduleName'=>'Новости')));
				elseif($module->name=='srbac')
					Yii::app()->setModules(array($module->name=>array('moduleName'=>'srbac')));
				elseif($module->name=='faq')
					Yii::app()->setModules(array($module->name=>array('moduleName'=>'FAQ')));
			}
			
            return true;
	}

	
}
