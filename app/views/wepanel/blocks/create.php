<h2><?php echo $this->pageTitle;?></h2>
<div id="msgs"></div>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'blocks-form',
	'enableAjaxValidation'=>true,
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note">Поля помеченные звездочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'vis'); ?>
		<?php echo $form->checkBox($model,'vis'); ?>
		<?php echo $form->error($model,'vis'); ?>
	</div>

	<?php
		if(!$model->isNewRecord)
			$this->renderPartial(
				'//wepanel/_images', 
				array(
					'images'=>$images, 
					)
				);
	?>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Применить',array('name'=>'apply')); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
