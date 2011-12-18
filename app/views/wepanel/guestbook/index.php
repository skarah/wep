<div id="msgs"></div>
<h2><?=$this->pageTitle?></h2>
<?php 
if(sizeof($model)>0)
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
				'value'=>'CHtml::link($data->name, "/wepanel/guestbook/act/edit/item/".$data->id,array("title"=>"Редактировать отзыв"))',
				'filter'=>$model->name,
				),
                'author',
                'content',
                array(
					'class'=>'CButtonColumn',
					'template'=>'{update}{delete}',
					
					'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/33s.png',
					'deleteButtonLabel'=>'Удалить отзыв',
					'deleteButtonUrl'=>'Yii::app()->createUrl("/wepanel/guestbook/act/delete", array("item"=>$data->id))',
					'deleteConfirmation' => 'Вы действительно хотите удалить этот отзыв?',
					
					'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/WE/images/20s.png',
					'updateButtonLabel'=>'Редактировать отзыв',
					'updateButtonUrl'=>'Yii::app()->createUrl("/wepanel/guestbook/act/edit", array("item"=>$data->id))',
				   
				),
			)
         )
       );?>
