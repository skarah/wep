<div id="msgs"></div>
<h2><?=$this->pageTitle?></h2>

<?php 
if(!empty($model) && sizeof($model)>0)
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'news-grid',
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
				'name'=>'name',
				'type'=>'raw',
				'value'=>'CHtml::link($data->name, "/wepanel/tags/act/edit/item/".$data->id,array("title"=>"Редактировать тег"))',
				'filter'=>$model->name,
				),
                'alias',
				array(
				'name'=>'section',
				'type'=>'raw',
				'value'=>'$data->sections->name',
				'filter'=>$model->sections,
				),
                array(
					'class'=>'CButtonColumn',
					'template'=>'{update}{delete}',
					
					'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/33s.png',
					'deleteButtonLabel'=>'Удалить тег',
					'deleteButtonUrl'=>'Yii::app()->createUrl("/wepanel/tags/act/delete", array("item"=>$data->id))',
					'deleteConfirmation' => 'Вы действительно хотите удалить этот тег?',
					
					'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/20s.png',
					'updateButtonLabel'=>'Редактировать тег',
					'updateButtonUrl'=>'Yii::app()->createUrl("/wepanel/tags/act/edit", array("item"=>$data->id))',
				   
				),
			)
         )
       );?>
