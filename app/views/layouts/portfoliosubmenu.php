		                    <div class="top_menu png_bg">
                        <div class="top_menu_container png_bg">
                            <div class="top_menu_bottom png_bg">
                                <div class="top_menu_center png_bg">
                                    
												<h1><?=$this->page['title']?></h1>
											<ul>
			<li><strong><?=$this->page['total']?> работ</strong> в портфолио:</li>
			<li<?=(!empty($_GET['tag']) && $_GET['tag']=='fresh'?' class="active"':'')?>><a href="/portfolio/fresh/" title="">Свежие работы</a></li>
			<li<?=(!empty($_GET['tag']) && $_GET['tag']!='fresh' && $_GET['tag']!='list'?' class="active"':'')?>><a href="/portfolio/theme/" title="">Работы по темам</a></li>
			<li<?=(!empty($_GET['tag']) && $_GET['tag']=='list'?' class="active"':'')?>><a href="/portfolio/list/" title="">Все работы одним списком</a></li>
		</ul>
		<div class="hr"></div>  
		<ul class="tags">
			<?php 
			foreach($this->page['portfolioMenu'] as $url=>$name)
			{
				?>
						<li<?=(!empty($_GET['tag']) && $_GET['tag']==$url?' class="active"':'')?>><a href="/<?=$this->page['mainUrl']?>/<?=$url?>/" title="<?=$name?>"><span><?=$name?></span></a></li>
			<?php
			}
			?>

					</ul>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
