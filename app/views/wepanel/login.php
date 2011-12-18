<?php
$this->pageTitle=Yii::app()->name . ' - Login';
?>

<h1>Войти в панель управления</h1>

<p>Вы пытаетесь войти в область администрирования сайта. Введите ваш логин и пароль. </p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>37)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>37)); ?>
		<?php echo $form->error($model,'password'); ?>	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
		<?php echo CHtml::submitButton('Войти'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
