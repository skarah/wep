		                    <div class="top_menu png_bg">
                        <div class="top_menu_container png_bg">
                            <div class="top_menu_bottom png_bg">
                                <div class="top_menu_center png_bg">
                                            <h1><?=$this->page['model']->name?></h1>
                                            <span class="date"><?$date=split('-',$this->page['model']->date);?><?=$date[2]?>.<?=$date[1]?>.<?=$date[0]?></span>
                                            <ul>
			<?php 
			$i=0;
			foreach($this->page['portfolioPageMenu'] as $url=>$name)
			{
				?>
						<li<?=($i==0?' class="first"':'')?>><a href="/<?=$this->page['mainUrl']?>/<?=$url?>/" title="<?=$name?>"><?=$name?></a></li>
			<?php
				$i++;
			}
			?>
                                                        </ul>
							<?if(!empty($this->page['nextProject'])){?><a class="right png_bg" href="/<?=$this->page['mainUrl']?>/<?=$this->page['nextProject']->id?>.html"></a><?}?>
                            <?if(!empty($this->page['prevProject'])){?><a class="left png_bg" href="/<?=$this->page['mainUrl']?>/<?=$this->page['prevProject']->id?>.html"></a><?}?>

                                </div>
                            </div>
                        </div>
                    </div>
