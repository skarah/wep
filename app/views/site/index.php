				<!-- О студии -->
				<div class="about clearfix">
					<div class="about_text">
                                            
                                           <?=($this->page['indexText']->vis?$this->page['indexText']->content:'')?>
					</div>
                                        <!-- Vacancy -->
					<?=($this->page['jobText']->vis?$this->page['jobText']->content:'')?>
					<div class="clearfix"></div>
				</div> <!-- end .about -->

				<!-- Отзывы -->
				<div class="feedbacks clearfix"> 
					        <div class="left">
            <h3><?=$this->page['randomFromGuestbook']->name?></h3>

            <p>Только правдивые <a href="/about/testimonials/" title="отзывы">отзывы</a> </p>
        </div>
        <div class="right">
            <blockquote>
                    <?=htmlspecialchars_decode($this->page['randomFromGuestbook']->content)?>
                    <p class="info"><?=$this->page['randomFromGuestbook']->author?></p>

            </blockquote>
        </div>
    					<div class="clearfix"></div>
				</div> <!-- end .feedbacks -->

				<!-- Проекты -->
				<div class="projects clearfix"> 
					<div class="left">
						<h3>Мы гордимся этими проектами:</h3>

					</div>
					<div class="right">
                                                <ul id="projects_slider">
            <?for($i=0;$i<sizeof($this->page['bannerInfo']);$i++){?>
            <li>
            <a href="http://<?=$this->page['bannerInfo'][$i]->link?>" title="<?=$this->page['bannerInfo'][$i]->name?>" class="preview"><img src="/content/<?=$this->page['bannerImage'][$i]->file?>" alt="<?=$this->page['bannerInfo'][$i]->link?>"></a>
            <a class="title" href="http://<?=$this->page['bannerInfo'][$i]->link?>" title="<?=$this->page['bannerInfo'][$i]->name?>"><?=$this->page['bannerInfo'][$i]->name?></a>
            <p>Перейти на сайт: <a href="http://<?=$this->page['bannerInfo'][$i]->link?>" title="<?=$this->page['bannerInfo'][$i]->name?>"><?=$this->page['bannerInfo'][$i]->link?></a></p>
			</li>
			<?}?>
        </ul>
    					</div>
					<div class="clearfix"></div>
				</div> <!-- end .projects -->
<!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('.preview,img,.png_bg,.journal_link,.bx-prev,.bx-next,.active,.pager-active,.logo,.right,.nyroModalCloseButton,#name,.nyroModalCont,.input,input,select,.chzn-container-single');
    </script>
    <![endif]-->

	<script src="js/jquery.bxSlider.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
	 	/* ============ TOP SLIDER ========== */
	    var top_slider = $('#top_panel_slider').bxSlider({
			pager: false,  // true / false - display a pager
			onBeforeSlide: function(currNumber){
				top_slider_pager.goToSlide(currNumber);
			},
			infiniteLoop: true
		});
		
		
		/* PAGER */
		var top_slider_pager = $('#top_panel_pager ul').bxSlider({
			pager: false,                        // true / false - display a pager
			displaySlideQty: 3,
			infiniteLoop: true, 		
			onBeforeSlide: function(currNumber){
				var current_page = $('#top_panel_pager ul li').eq(currNumber+1);
				$('#top_panel_pager ul li').each(function(e){
					$('#top_panel_pager ul li').eq(e).children("a").removeClass("pager-active");
				});			
				current_page.children("a").addClass("pager-active");
			},
			onAfterSlide: function(cn){
				if(cn == 0) {
					//left: -401px
					$('#top_panel_pager ul').css('left','-301px');
				}
			}
		});

		$('#top_panel_pager li.page1 a').click(function(){top_slider.goToSlide(0); return false;});
		$('#top_panel_pager li.page2 a').click(function(){top_slider.goToSlide(1); return false;});
		$('#top_panel_pager li.page3 a').click(function(){top_slider.goToSlide(2); return false;});
		$('#top_panel_pager li.page4 a').click(function(){top_slider.goToSlide(3); return false;});
		$('#top_panel_pager li.page5 a').click(function(){top_slider.goToSlide(4); return false;});
		$('#top_panel_pager li.page6 a').click(function(){top_slider.goToSlide(5); return false;});
		$('#top_panel_pager li.page7 a').click(function(){top_slider.goToSlide(6); return false;});
		$('#top_panel_pager li.page8 a').click(function(){top_slider.goToSlide(7); return false;});
        $('#top_panel_pager li.page9 a').click(function(){top_slider.goToSlide(8); return false;});
		$('#top_panel_pager li.page10 a').click(function(){top_slider.goToSlide(9); return false;});
		/* =========================================== */
		
		
		/* ============== JOURNAL SLIDER ============= */
		$('#journal_slider').bxSlider({
			mode: 'vertical',
			pager: false,                        // true / false - display a pager
			displaySlideQty: 3,
			infiniteLoop: true, 		
			onBeforeSlide: function(currNumber){
				$('#journal_slider li').each(function(e){
					$('#journal_slider li').eq(e).removeClass("big");
					$('#journal_slider li').eq(e).removeClass("medium");
				});
				$('#journal_slider li').eq(currNumber+1).addClass("big");
				$('#journal_slider li').eq(currNumber+1).children("a").animate({fontSize: "30px"}, 300, function(){});
				$('#journal_slider li').eq(currNumber+2).addClass("medium");
				$('#journal_slider li').eq(currNumber+2).children("a").animate({fontSize: "16px"}, 300);
				$('#journal_slider li').eq(currNumber+3).children("a").animate({fontSize: "14px"}, 300);
			}
		});
		/* =========================================== */


		/* ============== PROJECTS SLIDER ============ */
		$('#projects_slider').bxSlider({});		
		/* =========================================== */

		/* ======= Форма email ======== */
	    $('.mail_us').nyroModal();

	});
	</script>
