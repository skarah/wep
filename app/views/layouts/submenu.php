					<div class="top_menu png_bg">
				<div class="top_menu_container png_bg">
											<div class="top_menu_bottom">
							<div class="top_menu_center">

											<h1><?=$this->page['title']?></h1>
		<ul>
			<?php 
			foreach($this->page['subMenu'] as $url=>$name)
			{
				?>
						<li<?=($_GET['url']==$url?' class="active"':'')?>><a href="/<?=$this->page['mainUrl']?>/<?=$url?>/" title="<?=$name?>"><?=$name?></a></li>
			<?php
			}
			?>
					</ul>

		<div class="clearfix"></div>
									</div>
						</div>
									</div>
			</div>
