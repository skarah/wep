<div class="works">
			<?php 
			for($i=0;$i<sizeof($model);$i++)
			{
				$date=split('-',$model[$i]['date']);
				?>
                                                <div class="anons<?=(($i+1)%3==0?' right':'')?>">
                     
                            <div class="anons_thumb">
                                <a href="/<?=$this->page['mainUrl']?>/<?=$model[$i]['id']?>.html" title="" class="png_bg">
                                    <img src="/content/<?=$this->page['pics'][$i]['file']?>" height="200" width="278">
                                </a>
                            </div>
                            <div class="info">
                                <a href="/<?=$this->page['mainUrl']?>/<?=$model[$i]['id']?>.html" title="<?=$model[$i]['name']?>" class="title"><?=$model[$i]['name']?></a>

                                <span class="date"><?=$date[2]?>.<?=$date[1]?>.<?=$date[0]?></span>
                                <ul class="tags">
			<?php 
			$j=0;
			foreach($this->page['tags'][$i] as $url=>$name)
			{
				?>
						<li<?=($j==0?' class="first"':'')?>><a href="/<?=$this->page['mainUrl']?>/<?=$url?>/" title="<?=$name?>"><?=$name?></a></li>
			<?php
				$j++;
			}
			?>
                                                                        </ul>
                            </div>
                        </div> <!-- end .anons -->
			<?php
			}
			?>

                     

                    <div class="clearfix"></div>
                </div>
<?=$this->page['text']?>
