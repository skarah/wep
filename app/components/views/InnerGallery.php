		<span style="display:block"><?
		for($i=0;$i<sizeof($images);$i++)
		{
			?><img src="<?=Yii::app()->params['thumbDir'].Yii::app()->params['thumbPrefix'].$images[$i]->file?>" height="75"><?
		}
		?></span>
