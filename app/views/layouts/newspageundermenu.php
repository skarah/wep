<div class="journal">
						<div class="journal_container">
							<?if(!empty($this->page['nextNews'])){?><a class="right png_bg" href="/<?=$this->page['mainUrl']?>/<?=$this->page['nextNews']->id?>.html"><?=$this->page['nextNews']->name?></a><?}?>
                            <?if(!empty($this->page['prevNews'])){?><a class="left png_bg" href="/<?=$this->page['mainUrl']?>/<?=$this->page['prevNews']->id?>.html"><?=$this->page['prevNews']->name?></a><?}?>
        							<div class="clearfix"></div>
						</div>
					</div>
