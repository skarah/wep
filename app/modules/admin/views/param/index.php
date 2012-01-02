<div id="msgs"></div>
<h2><?=$this->pageTitle?></h2>
<?php 
if(sizeof($model)>0)
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'params-grid',
        //'template'=>'{summary} {items} {pager}',
        'dataProvider'=>$model->search(),
        //'filter'=>$model,
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
				'name'=>'title',
				'type'=>'raw',
				'value'=>'CHtml::link($data->title, "/'.$this->module->id.'/param/edit/item/".$data->id,array("title"=>"Редактировать запись в настройках"))',
				'filter'=>$model->title,
				),
                'value',
                'name',
                array(
					'class'=>'CButtonColumn',
					'template'=>'{update}{delete}',
					
					'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/33s.png',
					'deleteButtonLabel'=>'Удалить запись из настроек',
					'deleteButtonUrl'=>'Yii::app()->createUrl("/'.$this->module->id.'/param/delete", array("item"=>$data->id))',
					'deleteConfirmation' => 'Вы действительно хотите удалить эту запись из настроек?',
					
					'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/20s.png',
					'updateButtonLabel'=>'Редактировать запись в настроках',
					'updateButtonUrl'=>'Yii::app()->createUrl("/'.$this->module->id.'/param/edit", array("item"=>$data->id))',
				   
				),
			)
         )
       );?>
