<h2><?php echo $this->pageTitle;?></h2>
<div id="msgs"></div>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Поля помеченные звездочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'section'); ?>
		<?php echo CHtml::dropDownList('News[section]', $model->section, $list['pid'], array('empty'=>'Выберете в какой раздел новостей включить'));?>
		<?php echo $form->error($model,'section'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mark'); ?>
		<?php echo $form->checkBox($model,'mark'); ?>
		<?php echo $form->error($model,'mark'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'short'); ?>
		<div align="right">
		<?php $this->widget('application.modules.admin.extensions.ckeditor.CKEditor', array( 'model'=>$model, 'attribute'=>'short', 'editorTemplate'=>'basic', ));?>
		</div>
		<?php echo $form->error($model,'short'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<div align="right">
		<?php $this->widget('application.modules.admin.extensions.ckeditor.CKEditor', array('model'=>$model, 'attribute'=>'content', 'editorTemplate'=>'full', ));?>
		</div>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'language'=>'ru',
			'model'=>$model,
			'attribute'=>'date',
			'options'=>array(
				'showAnim'=>'fold',
				'dateFormat'=>'yy-mm-dd',
			),
		   
			'htmlOptions'=>array(
				'style'=>'height:20px;'
			),
		)); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>
	<?php
		if(!$model->isNewRecord)
			$this->renderPartial(
				'_images', 
				array(
					'images'=>$images
					)
				);
	?>

	<div class="title">Теги</div>
	<div class="row">
	<?php echo CHtml::checkBoxList('Tag', $list['selected'], $list['tag']);?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Применить',array('name'=>'apply')); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

