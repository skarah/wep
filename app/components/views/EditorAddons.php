		<div align="right" style="padding-top:100px;"><a id="add_snippet" title="Добавить сниппет">Сниппет</a> <img src="/WE/images/57s.png">&nbsp;&nbsp;</div>
		<div id="snippets" style="display:none; padding:10px; background:#ffffff;width:85px;border: solid #000000 1px;">
		<?
		for($i=0;$i<sizeof($snippetList);$i++)
		{
			?><div id="snippet<?=$snippetList[$i]->id?>" style="display:none"><?=$snippetList[$i]->content?></div><a href="javascript:add_to_editor('snippet<?=$snippetList[$i]->id?>');"><?=$snippetList[$i]->name?></a><br /><?
		}
		?>
		<br /><br />
		<a href="/wepanel/snippets" target="_blank">Все сниппеты</a>
		</div>
		<div align="right" style="padding-top:10px;"><a id="add_gallery" title="Добавить галерею">Галерею</a> <img src="/WE/images/57s.png">&nbsp;&nbsp;</div>
		<div id="galleries" style="display:none; padding:10px; background:#ffffff;width:85px;border: solid #000000 1px;">
		<?
		for($i=0;$i<sizeof($galleriesList);$i++)
		{
			?><a href="javascript:add_gallery_to_editor('<?=$galleriesList[$i]->id?>','<?=$galleriesList[$i]->name?>');"><?=$galleriesList[$i]->name?></a><br /><?
		}
		?>
		<br /><br />
		<a href="/wepanel/galleries" target="_blank">Все галлереи</a>
		</div>
<?		Yii::app()->clientScript->registerScript('show', "
				$('#add_snippet').click(function(){
				$('#snippets').slideToggle();
				return false;
				});
				
				$('#add_gallery').click(function(){
				$('#galleries').slideToggle();
				return false;
				});
			");
?>
<script>
function add_to_editor(divId)
{
	CKEDITOR.instances.<?=$modelName?>_content.insertHtml( $('#'+divId).html() );
}
function add_gallery_to_editor(galleryId,galleryName)
{
	CKEDITOR.instances.<?=$modelName?>_content.insertHtml( '<img src="/WE/images/gallery.png" id="gallery'+galleryId+'" title="'+galleryName+' (ID='+galleryId+')" style="display:block">' );
}
</script>
