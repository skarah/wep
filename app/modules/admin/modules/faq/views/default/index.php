<div id="msgs"></div>
<h2><?=$this->pageTitle?></h2>

<?php 
if(sizeof($model)>0)
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'faq-grid',
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
				'name'=>'question',
				'type'=>'raw',
				'value'=>'CHtml::link($data->question, "/admin/faq/edit/".$data->id,array("title"=>"Редактировать запись"))',
				'filter'=>$model->question,
				),
                'answer',
                array(
					'class'=>'CButtonColumn',
					'template'=>'{update}{delete}',
					
					'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/33s.png',
					'deleteButtonLabel'=>'Удалить запись',
					'deleteButtonUrl'=>'Yii::app()->createUrl("/admin/faq/delete/$data->id")',
					'deleteConfirmation' => 'Вы действительно хотите удалить эту запись?',
					
					'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/20s.png',
					'updateButtonLabel'=>'Редактировать запись',
					'updateButtonUrl'=>'Yii::app()->createUrl("/admin/faq/edit/$data->id")',
				   
				),
			)
         )
       );?>
