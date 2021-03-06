<div id="msgs"></div>
<h2><?=$this->pageTitle?></h2>
<?php 
if(sizeof($model)>0)
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'news-grid',
        'dataProvider'=>$model->search(),
        //'filter'=>$model,
        'skin'=>false,
        'pager'=>array(
			'class'=>'CLinkPager',
			'header'=>'Перейти на страницу:',
			'firstPageLabel'=>'&lt;&lt;',
			'prevPageLabel'=>'&lt; Предыдущая',
			'nextPageLabel'=>'Следующая &gt;',	
			'lastPageLabel'=>'&gt;&gt;',
		),
		'summaryText'=>'Показаны {start}-{end} из {count}.',
        'columns'=>array(
				array(
				'name'=>'name',
				'type'=>'raw',
				'value'=>'CHtml::link($data->name, "/'.$this->module->id.'/gallery/edit/".$data->id,array("title"=>"Редактировать галерею"))',
				'filter'=>$model->name,
				),
                array(
					'class'=>'CButtonColumn',
					'template'=>'{update}{delete}',
					
					'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/33s.png',
					'deleteButtonLabel'=>'Удалить галерею',
					'deleteButtonUrl'=>'Yii::app()->createUrl("/'.$this->module->id.'/gallery/delete/$data->id")',
					'deleteConfirmation' => 'Вы действительно хотите удалить эту галерею?',
					
					'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/20s.png',
					'updateButtonLabel'=>'Редактировать галерею',
					'updateButtonUrl'=>'Yii::app()->createUrl("/'.$this->module->id.'/gallery/edit/$data->id")',
				   
				),
			)
         )
       );?>
