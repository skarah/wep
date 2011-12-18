 <div class="client_card png_bg png_bg">

                        <div class="client_card_bottom png_bg">
                            <div class="client_card_content png_bg">
                                <table>
                                    <tr>
                                        <td class="title">Клиент:</td>
                                        <td><?=$this->page['model']->client?></td>
                                    </tr>
                                    <tr>

                                        <td class="title">Задача:</td>
                                        <td><?=$this->page['model']->task?></td>
                                    </tr>
                                    <tr>
                                        <td class="title">Сайт:</td>
                                        <td>
                                        <a href="http://<?=$this->page['model']->site?>" target="_blank"><?=$this->page['model']->site?></a>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end .client_card -->

                    <div class="content">
                       <?=$this->page['model']->before_text?>

                    </div>
                    <br/>
                    <div class="work">
                        <div id="work_image_slider">
                            <ul>
                            <?
                            for($i=1;$i<sizeof($pic);$i++)
                            {?>
                                                                         <li>
                                            <div class="image">
                                                <div class="image_bottom">
                                                    <div class="image_center">

                                                        <img src="/content/<?=$pic[$i]->file?>" alt="" />
                                                    </div>
                                                </div>
                                            </div>
                                         </li>
                             <?}?>
                                                                </ul>
                        </div>
                        <div id="work_text_slider">
                            <div class="pager-content">

                            </div>
                            <ul>
                            <?
                            for($i=1;$i<sizeof($pic);$i++)
                            {?>
										<li>
                                            <div class="slider_text">
                                                <p><?=$pic[$i]->name?></p>
                                            </div>
                                        </li>

                           <?}?>
                                                                </ul>
                        </div>
                        <div class="clearfix"></div>

                        <div class="content clearfix">
                             <?=$this->page['model']->after_text?>
                        </div>
                        <div id="note">

                            <div class="hr"></div>
                            <blockquote class="png_bg">
                                <p>
                                    Про то, как мы делаем сайты, вы можете почитать в разделе «<a href="/services/create/">Создание сайтов</a>». О том, как мы их продвигаем — в разделе «<a href="/services/seo/">Продвижение сайтов</a>». Узнать, как провести интересную рекламную кампанию, можно в разделе «<a href="/services/reklama/">Реклама в Интернете</a>».
                                    Но это ещё не всё, ведь мы осуществляем <a href="/services/audit/">аудит</a> и <a href="/services/support/">сопровождение сайтов</a>, <a href="/services/domain/">регистрируем домены</a>, предоставляем <a href="/services/hosting/">хостинг</a> и помогаем открывать <a href="/services/mail/">корпоративную почту</a>.
                                </p>

                            </blockquote>
                            <div class="hr"></div>
                        </div>
                    </div>  <!-- end .work -->
            <script src="/js/jquery.bxSlider.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                /* ============ SLIDER ========== */
                var work_image_slider = $('#work_image_slider ul').bxSlider({
                    pager: false,  // true / false - display a pager
                    controls: false
                });

                var work_text_slider = $('#work_text_slider ul').bxSlider({
                    pager: true,  // true / false - display a pager
                    onBeforeSlide: function(currNumber){
                        work_image_slider.goToSlide(currNumber);
                    },
                    infiniteLoop: true,
                    pagerSelector: "#work_text_slider .pager-content"
                });
            });
        </script>
