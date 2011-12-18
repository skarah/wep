<div class="sam_sebya png_bg">

					<h2>Сам себя не похвалишь,</h2>
					<p>зато наши любимые клиенты с удовольствием пишут красивые отзывы.</p>
				</div>

				<div class="hr"></div>
<?php for($i=0;$i<sizeof($model);$i++) {?>
						<div class="feedbacks clearfix"> 
					<div class="left">

						<h3><?=$model[$i]->name?>:</h3>
					</div>
					<div class="right">
						<blockquote>
							<?=$model[$i]->content?>
							<p class="info"><?=$model[$i]->author?></p>
						</blockquote>

					</div>
					<div class="clearfix"></div>
				</div> 
<?}?>
