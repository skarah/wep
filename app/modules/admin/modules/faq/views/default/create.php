<h2><?php echo $this->pageTitle;?></h2>
<div id="msgs"></div>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля помеченные звездочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'question'); ?>
		<div align="right">
		<?php $this->widget('application.modules.admin.extensions.ckeditor.CKEditor', array( 'model'=>$model, 'attribute'=>'question', 'editorTemplate'=>'basic', ));?>
		</div>
		<?php echo $form->error($model,'question'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'answer'); ?>
		<div align="right">
		<?php $this->widget('application.modules.admin.extensions.ckeditor.CKEditor', array('model'=>$model, 'attribute'=>'answer', 'editorTemplate'=>'full', ));?>
		</div>
		<?php echo $form->error($model,'answer'); ?>
	</div>



	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Применить',array('name'=>'apply')); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

