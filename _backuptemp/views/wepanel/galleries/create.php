<h2><?php echo $this->pageTitle;?></h2>
<div id="msgs"></div>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'galleries-form',
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
