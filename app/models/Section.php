<?php

/**
 * Класс модели для таблицы "WE_section" для Разделов сайта
 *
 * Список доступных полей в таблице 'WE_section':
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property integer $url
 * @property string $content
 * @property integer $posled
 * @property integer $vis
 * @property integer $child_vis
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class Section extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'WE_section';
	}


	public function rules()
	{

		return array(
			array('type, name, url, content', 'required','message' => 'Поле не может быть пустым.'),
			array('pid, type, posled, vis, child_vis', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>50),
			array('meta_title, meta_description, meta_keywords', 'length', 'max'=>255),
			array('id, pid, type, name, url, content, posled, vis, child_vis, meta_title, meta_description, meta_keywords', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
        return array(
            //'tags'=>array(self::HAS_MANY, 'Tag', 'section'),
            //'tags'=>array(self::MANY_MANY, 'Tag','tbl_post_category(post_id, category_id)'),
            'sectionType' => array(self::BELONGS_TO, 'Type', 'type'),
            'child' => array(self::HAS_MANY, 'Section', 'pid', 'order'=>'child.posled ASC', 'together'=>true),
            'childCount'=>array(self::STAT, 'Section', 'pid'),
        );
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pid' => 'В раздел',
			'type' => 'Тип',
			'name' => 'Название',
			'url' => 'Url маска',
			'content' => 'Текст',
			'posled' => 'Порядок',
			'vis' => 'Отображать',
			'child_vis' => 'Отображать подразделы',
			'meta_title' => 'Заголовок',
			'meta_description' => 'Описание',
			'meta_keywords' => 'Ключевые слова',
		);
	}

	public function search()
	{
		// Тут можно удалить атрибуты, которые не нужны для поиска
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('pid',$this->pid);
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('posled',$this->posled);
		$criteria->compare('vis',$this->vis);
		$criteria->compare('child_vis',$this->child_vis);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function treeArray($id=false) // формируем массив для отображения дерева разделов
	{
		$dbData=(!empty($id)?Section::model()->with('childCount')->findAllByAttributes(array('pid' => $id),array('select'=>'id, name, type')):Section::model()->with('childCount')->findAllByAttributes(array('pid' => NULL),array('select'=>'id, name, type','order'=>'t.posled ASC')));
		$i=0;
		foreach($dbData as $key=>$section)
		{
			$sections[$i]=array(
				'text'=>($section->type==1?'<img src="/WE/images/13s.png" title="Раздел"> ':'').($section->type==2?'<img src="/WE/images/39s.png" title="Новости"> ':'').
						($section->type==3?'<img src="/WE/images/51s.png" title="Галерея"> ':'').($section->type==4?'<img src="/WE/images/52s.png" title="Портфолио"> ':'').
						($section->type==5?'<img src="/WE/images/53s.png" title="Отзывы"> ':'')."<a href=\"/admin/section/edit/{$section->id}\">".$section->name."</a> ".
						($section->type!=1?'<a href="/admin/'.($section->type==2?'news':($section->type==3?'galleries':($section->type==4?'portfolio':($section->type==5?'guestbook':'')))).'" title="Перейти к содержимому"><img src="/WE/images/54s.png" title="Перейти к содержимому"></a> ':'').
						"<a href=\"/admin/section/create/".$section->id."\" title=\"Добавить подраздел\"><img src=\"/WE/images/31s.png\"></a> "."<a href=\"/admin/section/edit/".$section->id."\" title=\"Редактировать раздел\"><img src=\"/WE/images/20s.png\"></a> ".
						CHtml::ajaxLink(
							"<img src=\"/WE/images/33s.png\"> ",
							array('/admin/section/delete/'.$section->id),
							array('type' => 'GET', 'update' => '#msgs'),
							array('title' => 'Удалить раздел со всеми подразделами', 'confirm' => "Вы действительно хотите удалить раздел со всеми его подразделами?")
							)." ",
				'expanded' => true);
				
			if($section['childCount']>0) 
				$sections[$i]['children']=Section::model()->treeArray($section->id);
			$i++;
		}
		if(!empty($sections)) return $sections;
		else return false;
	}
	
	public function treeList($id=false,$level=0) // формируем массив для отображения выпадающего списка разделов
	{
		$separator='';
		if($level>0) 
		{
			$separator="¦";
			for($i=0;$i<$level;$i++)
				$separator.='--';
		}

		$dbData=(!empty($id)?Section::model()->with('childCount')->findAllByAttributes(array('pid' => $id),array('select'=>'id, name')):Section::model()->with('childCount')->findAllByAttributes(array('pid' => NULL),array('select'=>'id, name, type','order'=>'t.posled ASC')));
		foreach($dbData as $key=>$section)
		{
			$sections[$section->id] = $separator.$section->name;
			
			if($section['childCount']>0)
			{
				$level++;
				$sections=$sections+Section::model()->treeList($section->id,$level);
				$level--;
			}
		}
		return $sections;
	}

	public function treeMapList($id=false,$level=0,$url='') // формируем массив для отображения карты сайта
	{
		$dbData=(!empty($id)?Section::model()->findAllByAttributes(array('pid' => $id,'vis'=>1),array('order' => 'posled')):Section::model()->findAllByAttributes(array('pid' => NULL,'vis'=>1),array('order' => 'posled')));
		$sections=array();
		for($i=0;$i<sizeof($dbData);$i++)
		{
			$sections[(!empty($url)?$url.'/':'').$dbData[$i]['url']] = $dbData[$i]['name'];
				$childrenNum=Section::model()->countByAttributes(array('pid' => $dbData[$i]['id'],'vis'=>1));
				if($childrenNum>0)
				{
					$level++;
					$sections=$sections+Section::model()->treeMapList($dbData[$i]['id'],$level,$dbData[$i]['url']);
				}
		}
		$level--;
		return $sections;
	}

	public function getSectionUrl($id=false)
	{
		if(!empty($id))
		{
			$model=Section::model()->findByPk($id);
			return $model->url;
		}
		else return false;
	}

	public function getSearchList($searchString='')
	{
		//$model=Section::model()->findAll('name like "%'.$searchString.'%" or content like "%'.$searchString.'%"',array('order' => 'posled'));
		$criteria = Section::model()->getDbCriteria()->addSearchCondition('name', '%'.$searchString.'%', false, 'OR')->addSearchCondition('content', '%'.$searchString.'%', false, 'OR');
		$model=Section::model()->findAll($criteria);
		
		for($i=0;$i<sizeof($model);$i++)
		{
			if(!empty($model[$i]->pid))
				$model[$i]->url=Section::model()->getSectionUrl($model[$i]->pid).'/'.$model[$i]->url;
		}
		return $model;
	}

	public function treeUrl($id=false,$url='') // рекурсивно формируем урл для подраздела проходя по всем родителям
	{
		if(!empty($id))
		{
			$section=Section::model()->findByPk($id);
			$urlString=$section->url;
			if(!empty($section->pid))
				$urlString=Section::model()->treeUrl($section->pid,$urlString).'/'.$urlString;
			return $urlString;
		}
		else return false;
	}
	
	public function treeDelete($id=false) // рекурсивное удаление разделов со всеми вложенными подразделами (обрабатывается аякс запрос)
	{
		if(!empty($id))
		{
			$childrenNum=Section::model()->countByAttributes(array('pid' => $id));
			if($childrenNum>0)
			{
				$children=Section::model()->findAllByAttributes(array('pid' => $id));
				for($i=0;$i<sizeof($children);$i++)
					Section::model()->treeDelete($children[$i]['id']);
			}
			Images::model()->deleteImage($id,'Section');
			Section::model()->deleteByPk($id);
			return true;
		}
		else return false;
	}
	
	public function getPageData($alias=array())
	{
		Params::model()->setSiteParams();
		
		if(sizeof($alias)>0)
		{
			$page=array();
			
			if(empty($alias[1]))
			{
				if(Section::model()->countByAttributes(array('url'=>$alias[0]))>0)
				{
					$model=Section::model()->findByAttributes(array('url'=>$alias[0]));
									
					$page['mainUrl']=$model->url;
					$page['subMenu']=CHtml::listData(Section::model()->findAllByAttributes(array('pid'=>$model->id)), 'url', 'name');
				}
			}
			else
			{
				if(Section::model()->countByAttributes(array('url'=>$alias[1]))>0)
				{
					$parent=Section::model()->findByAttributes(array('url'=>$alias[1]));
					$model=Section::model()->findByAttributes(array('url'=>$alias[0]));
					
					$page['mainUrl']=$parent->url;
					$page['subMenu']=CHtml::listData(Section::model()->findAllByAttributes(array('pid'=>$parent->id)), 'url', 'name');
				}
			}
			
			$page['title']=$model->name;
			$page['metaTitle']=!empty($model->meta_title)?$model->meta_title:Yii::app()->params['siteTitle'];
			$page['metaDescription']=!empty($model->meta_description)?$model->meta_description:Yii::app()->params['siteDescription'];
			$page['metaKeywords']=!empty($model->meta_keywords)?$model->meta_keywords:Yii::app()->params['siteKeywords'];
			
			return $page;
		}
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
