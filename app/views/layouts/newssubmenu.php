		                    <div class="top_menu png_bg">
                        <div class="top_menu_container png_bg">
                            <div class="top_menu_bottom png_bg">
                                <div class="top_menu_center png_bg">
                                    
												<h1><?=$this->page['title']?></h1>
											<ul>
			<li<?=(empty($_GET['tag'])?' class="active"':'')?>><a href="/journal" title="">Все статьи</a></li>
			<li<?=(!empty($_GET['tag']) && $_GET['tag']=='theme'?' class="active"':'')?>><a href="/journal/theme/" title="">Статьи по темам</a></li>
			<li<?=(!empty($_GET['tag']) && $_GET['tag']=='recommend'?' class="active"':'')?>><a href="/journal/recommend/" title="">Настоятельно рекомендуем почитать</a></li>
		</ul>
		<div class="hr"></div>  
		<ul class="tags">
			<?php 
			foreach($this->page['newsMenu'] as $url=>$name)
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
