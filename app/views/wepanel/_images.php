<?		
			if(!empty($images) && sizeof($images)>0)
			{
				?>
	<div class="row">
		<label>Изображения</label>
		<div style="margin-left:110px">
				<?
				for($i=0;$i<sizeof($images);$i++)
				{
				?>
					<div style="float:left;padding:5px;margin-bottom:10px;margin-right:20px;background:#d3d3d3;width:322px" id="imgs<?=$images[$i]->id?>">
						<a href="/content/<?=$images[$i]->file;?>" target="_blank"><img src="<?=Yii::app()->params['thumbDir'].(is_file(Yii::getPathOfAlias('webroot').Yii::app()->params['thumbDir'].Yii::app()->params['thumbPrefix'].$images[$i]->file)?Yii::app()->params['thumbPrefix']:'').$images[$i]->file?>" width="100" height="100" align="left" style="margin-right:10px"></a>
						Название изображения:<br>
						<input type="text" value="<?=$images[$i]->name;?>" id="name<?=$images[$i]->id;?>">
						<div align="right" style="float:right;">
						<?
						echo CHtml::ajaxLink(
							"<img src=\"/WE/images/11.png\" style=\"margin-top:3px\"> ",
							array('/wepanel/updateimage'),
							array(
								'type' => 'GET', 
								'update' => '#msgs',
								'data'=>array(
									'ajax'=>true,
									'item' => $images[$i]->id,
									'name' => "js:function(){return $('#name".$images[$i]->id."').val();}()",
									'posled' => Yii::app()->controller->action->id=='galleries'?"js:function(){return $('#posled".$images[$i]->id."').val();}()":false,
									),
								),
							array('title' => 'Сохранить информацию об изображении')
							);
						?>
						<br>
						<?
						echo CHtml::ajaxLink(
							"<img src=\"/WE/images/33.png\"> ",
							array('/wepanel/deleteimage'),
							array('type' => 'GET', 'update' => '#msgs', 'data'=>array('ajax'=>true,'item' => $images[$i]->id)),
							array('title' => 'Удалить это изображение', 'confirm' => "Вы действительно хотите удалить это изображение?")
							);
						?>
						</div>
						<?if(Yii::app()->controller->action->id=='galleries'){?>Порядок: <input type="text" value="<?=$images[$i]->posled;?>" id="posled<?=$images[$i]->id;?>" size="3"><?}?>

					</div>
				<?
				}
				?>
		</div>
	</div>
				<?
			}
	?>
	<div class="row">
		<label>Добавить изображения</label>
	<?php
	$this->widget('CMultiFileUpload', array(
                'name' => 'images',
                //'file' => "<div class=\"MultiFile-label\"><a class=\"MultiFile-remove\" href=\"#images_wrap\">x</a> <span class=\"MultiFile-title\" title=\"File selected: 6.jpg\">6.jpg</span> Название изображения: <input type=\"text\"></div>",
                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                'duplicate' => 'Duplicate file!', // useful, i think
                'denied' => 'Invalid file type', // useful, i think
                'options'=>array(
					'afterFileAppend'=>"
						function(e, v, m)
						{ 
							$('.MultiFile-remove').remove();
							var fNum=0; 
							$('.MultiFile-label').each(
								function()
								{
									fNum++; 
									
									if($('#filename'+fNum).attr('name')!='filename'+fNum) 
										this.innerHTML='Файл: '+this.innerHTML+' Название изображения: <input type=\"text\" name=\"filename'+fNum+'\" id=\"filename'+fNum+'\">';
								}
							);  
						}",
				),
            ));
	?>
	</div>
