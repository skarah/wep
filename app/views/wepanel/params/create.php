<h2><?php echo $this->pageTitle;?></h2>
<div id="msgs"></div>
<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'params-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля помеченные звездочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Применить',array('name'=>'apply')); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
