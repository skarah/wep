<div class="search">
    <form action="/search/" method="POST">
        <input type="text" name="search" class="text" placeholder="например, создание сайтов" <?=(!empty($this->page['searchString'])?'value="'.$this->page['searchString'].'"':'')?>/>
        <input type="submit" name="submit" class="submit" value="искать">
    </form>
</div> <!-- end .search -->

<div class="content">
<?
if(!empty($this->page['links']) && !isset($_POST['search']))
{
	$level=0;
	foreach($this->page['links'] as $url=>$name)
	{
		$thisLevel=!ereg('/',$url)?0:1;
		if($level==0 && $thisLevel==1){?><ul><?}
		if($level==1 && $thisLevel==0){?></ul><?}
		$level=$thisLevel;
		
		if($thisLevel==0 && $url!='about')
		{
			?><a href='/<?=$url?>'><h2><?=$name?></h2></a><?
		}
		elseif($thisLevel==0 && $url=='about')
		{
			?><h2><?=$name?></h2><?
		}	
		else
		{
			?><li><a href='/<?=$url?>'><?=$name?></a></li><?
		}
		?>
	<?}
}
elseif(!empty($this->page['links']) && isset($_POST['search']))
{
	foreach($this->page['links'] as $url=>$name)
	{
		if($url!='about')
		{
			?><a href='/<?=$url?>'><h2><?=$name?></h2></a><?
		}
		elseif($url=='about')
		{
			?><h2><?=$name?></h2><?
		}
		?>
	<?}
}
else
{?>
    <div align="center"><p>Результатов не найдено</p></div>   <br><br><br><br><br><br><br><br><br><br><br><br>
   <br><br><br><br><br><br><br><br><br><br><br><br>
<?
}
?>
</div>	
