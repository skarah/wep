<h2><?php echo $this->pageTitle;?></h2>
<div id="msgs"></div>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'section-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Поля помеченные звездочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'pid'); ?>
		<?php echo CHtml::dropDownList('Section[pid]', $pid, $list['pid'], array('empty'=>'Выберете в какой раздел включить'));?>
		<?php echo $form->error($model,'pid'); ?>
	</div>	
	
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo CHtml::dropDownList('Section[type]', (!empty($model->type)?$model->type:(!empty($_GET['type'])?$_GET['type']:'1')), $list['type']);?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<b><?php echo Yii::app()->params['siteUrl']; echo '/'.$purl; echo $form->textField($model,'url'); ?></b> 
		<img src="/WE/images/57s.png"> <?php
		echo CHtml::link('Открыть на сайте', '#', array(
			'onclick'=>'window.open(\''.Yii::app()->params['siteUrl'].'/'.$purl.'\'+$("#Section_url").val()); return false;',
		));
		?>
		<?php echo $form->error($model,'url'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<div align="right" style="float:right">
		<?php $this->widget('application.extensions.ckeditor.CKEditor', array('model'=>$model, 'attribute'=>'content', 'editorTemplate'=>'full', ));?>
		</div>
		<? $this->widget('EditorAddons',array('modelName'=>get_class($model)));?>
		<br class="clear" />
		<?php echo $form->error($model,'content'); ?>
	</div>
	<div class="title">Визуальные опции</div>
	<div class="row">
		<?php echo $form->labelEx($model,'posled'); ?>
		<?php echo $form->textField($model,'posled',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'posled'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vis'); ?>
		<?php echo $form->checkBox($model,'vis'); ?>
		<?php echo $form->error($model,'vis'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'child_vis'); ?>
		<?php echo $form->checkBox($model,'child_vis'); ?>
		<?php echo $form->error($model,'child_vis'); ?>
	</div>
	<div class="title">Мета-данные</div>
	<div class="row">
		<?php echo $form->labelEx($model,'meta_title'); ?>
		<?php echo $form->textField($model,'meta_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_description'); ?>
		<?php echo $form->textField($model,'meta_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'meta_keywords'); ?>
		<?php echo $form->textField($model,'meta_keywords',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'meta_keywords'); ?>
	</div>
	<?php
		if(!$model->isNewRecord)
		{
			?>
	<div class="title">Изображения</div>		
			<?php
			$this->renderPartial(
				'//wepanel/_images', 
				array(
					'images'=>$images, 
					)
				);
		}
	?>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Применить',array('name'=>'apply')); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
