<div id="msgs"></div>
<h2><?=$this->pageTitle?></h2>
<?php 
if(sizeof($model)>0)
		$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'banners-grid',
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
				'value'=>'CHtml::link($data->name, "/wepanel/banners/act/edit/item/".$data->id,array("title"=>"Редактировать баннер"))',
				'filter'=>$model->name,
				),
                'link',
                array(
					'class'=>'CButtonColumn',
					'template'=>'{update}{delete}',
					
					'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/33s.png',
					'deleteButtonLabel'=>'Удалить баннер',
					'deleteButtonUrl'=>'Yii::app()->createUrl("/wepanel/banners/act/delete", array("item"=>$data->id))',
					'deleteConfirmation' => 'Вы действительно хотите удалить этот баннер?',
					
					'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/20s.png',
					'updateButtonLabel'=>'Редактировать баннер',
					'updateButtonUrl'=>'Yii::app()->createUrl("/wepanel/banners/act/edit", array("item"=>$data->id))',
				   
				),
			)
         )
       );?>
