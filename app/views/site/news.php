 			<?php 
			for($i=0;$i<sizeof($model);$i++)
			{
				list($dt,$time)=split(' ',$model[$i]['date']);
				$date=split('-',$dt);
				$model[$i]['name']=strip_tags($model[$i]['name']);
				?>
 <div class="post">
                                        <a href="/<?=$this->page['mainUrl']?>/<?=$model[$i]['id']?>.html" title="<?=$model[$i]['name']?>"><h2><?=$model[$i]['name']?></h2></a>
                                        <span class="date"><?=$date[2]?>.<?=$date[1]?>.<?=$date[0]?></span>

                                        <ul class="tags">
            <?php
			$j=0;
			foreach($this->page['tags'][$i] as $url=>$name)
			{
				?>
						<li<?=($j==0?' class="first"':'')?>><a href="/<?=$this->page['mainUrl']?>/<?=$url?>/" title="<?=$name?>"><span><?=$name?></span></a></li>
			<?php
				$j++;
			}
			?>
                                                    
                                        </ul>
                                                                                        <div class="content_with_image">
                                                        <a class="title_image png_bg" href="/<?=$this->page['mainUrl']?>/<?=$model[$i]['id']?>.html" title="<?=$model[$i]['name']?>">
                                                                                                                                        <img src="/content/<?=$this->page['pics'][$i]['file']?>" alt="<?=$model[$i]['name']?>">
                                                                                                                        </a>
                                                        <div class="text">

                                                                <?=$model[$i]['short']?>                                                                <a href="/<?=$this->page['mainUrl']?>/<?=$model[$i]['id']?>.html" title="" class="readmore">Дальше еще интереснее</a>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                </div>
                                        
                                </div>
                                                                        <?if(!empty($model[$i+1])){?><div class="hr"></div><?}?>
			<?php
			}
			?>

