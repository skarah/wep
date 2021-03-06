<div id="msgs"></div>
<h2><?=$this->pageTitle?></h2>
<?php 
if(sizeof($model)>0)
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'snippet-grid',
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
				'value'=>'CHtml::link($data->name, "/'.$this->module->id.'/snippet/edit/".$data->id,array("title"=>"Редактировать сниппет"))',
				'filter'=>$model->name,
				),
                array(
					'class'=>'CButtonColumn',
					'template'=>'{update}{delete}',
					
					'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/33s.png',
					'deleteButtonLabel'=>'Удалить сниппет',
					'deleteButtonUrl'=>'Yii::app()->createUrl("/'.$this->module->id.'/snippet/delete/$data->id")',
					'deleteConfirmation' => 'Вы действительно хотите удалить этот сниппет?',
					
					'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/20s.png',
					'updateButtonLabel'=>'Редактировать сниппет',
					'updateButtonUrl'=>'Yii::app()->createUrl("/'.$this->module->id.'/snippet/edit/$data->id")',
				   
				),
			)
         )
       );?>
