<?php

class Images extends CActiveRecord
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
		return 'WE_img';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file', 'required'),
			array('sid, posled', 'numerical', 'integerOnly'=>true),
			array('file', 'length', 'max'=>255),
			array('name', 'length', 'max'=>500),
			array('posled', 'length', 'max'=>3),
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
			'sid' => 'ID раздела',
			'name' => 'Название',
			'file' => 'Добавить изображение',
			'posled' => 'Порядок',
		);
	}
	
	public function upload($modelId=false,$modelName=false,$postArray=array())
	{
		if(!empty($modelId) && !empty($modelName))
		{
			$images = CUploadedFile::getInstancesByName('images');
			if (isset($images) && count($images) > 0) {
				// go through each uploaded image
				for ($i=0;$i<count($images);$i++) {
					if(preg_match('/image/',$images[$i]->type))
					{
						$picName=split('\.', strtolower($images[$i]->name));
						$hash=md5($images[$i]->name.date("Ymdhis"));
						$picName=$hash.'.'.$picName[1];
						$images[$i]->saveAs(Yii::getPathOfAlias('webroot').'/content/'.$picName);
						
						// add it to the main model now
						$img = new Images();
						$img->sid = $modelId;
						$img->file = $picName;
						$img->name = (!empty($postArray['filename'.($i+1)])?$postArray['filename'.($i+1)]:''); 
						$img->model_name=$modelName;
						$img->save(); // DONE
						// создаем превью для закаченых картинок
						
						$thumb = Yii::app()->thumb;
						$thumb->image = Yii::getPathOfAlias('webroot').'/content/'.$picName;
						$thumb->width = Yii::app()->params['thumbWidth'];
						$thumb->height = Yii::app()->params['thumbHeight'];
						$thumb->directory = Yii::getPathOfAlias('webroot').Yii::app()->params['thumbDir'];
						$thumb->prefix = Yii::app()->params['thumbPrefix'];
						$thumb->defaultName = $hash;
						$thumb->square = true;
						$thumb->createThumb();
						$thumb->save();
					}
				}
			}
		}
	}
	
	public function deleteImage($modelId=false,$modelName=false)
	{
		if(!empty($modelId) && !empty($modelName))
		{// добавить сюда удаление картинок не только из базы но и из папки content
			Images::model()->deleteAllByAttributes(array('sid'=>$modelId,'model_name'=>$modelName));
		}
	}
}
