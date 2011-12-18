					<div class="top_menu png_bg">
				<div class="top_menu_container png_bg">
					                                                <div class="top_menu_bottom png_bg">
                                                    <div class="top_menu_center png_bg">
                                            <h1><?=strip_tags($this->page['model']->name)?></h1>
                                            <span class="date"><?=$this->page['model']->date?></span>
                                            <ul>
			<?php 
			$i=0;
			foreach($this->page['newsPageMenu'] as $url=>$name)
			{
				?>
						<li<?=($i==0?' class="first"':'')?>><a href="/<?=$this->page['mainUrl']?>/<?=$url?>/" title="<?=$name?>"><?=$name?></a></li>
			<?php
				$i++;
			}
			?>
                                                        </ul>
							<?if(!empty($this->page['nextNews'])){?><a class="right png_bg" href="/<?=$this->page['mainUrl']?>/<?=$this->page['nextNews']->id?>.html"></a><?}?>
                            <?if(!empty($this->page['prevNews'])){?><a class="left png_bg" href="/<?=$this->page['mainUrl']?>/<?=$this->page['prevNews']->id?>.html"></a><?}?>

                                </div>
                            </div>
                        </div>
                    </div>
