<h2><?php echo $this->pageTitle;?></h2>
<div id="msgs"></div>
<div class="wide form">

<div class="form">
<?php echo CHtml::beginForm(array('id'=>'setmodule-form')); ?>
<?php foreach($allModules as $i=>$item): ?>
<div class="row">
<?php echo CHtml::activeHiddenField($item,"[$i]name"); ?>
<?php echo CHtml::checkBox('Module['.$i.'][show]',(!empty($allModules[$i]->id)?true:false)); ?>
<?php echo CHtml::activeLabel($item,$allModules[$i]->name); ?>
</div>
<?php endforeach; ?>
 
<?php echo CHtml::submitButton('Сохранить'); ?>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->
