</div>
<div class="order_form">
        <h2>Сразу к делу</h2>
        <div class="form png_bg">
                <div class="left">
                        <h3>ЭКСПРЕСС-ЗАЯВКА</h3>
                        <p>Не&nbsp;хотите терять ни&nbsp;секунды?</p>
                        <p>Пожалуйста, заполните форму.<br />
                        Это отнимет буквально пару<br />
                        минут вашего драгоценного<br />
                        времени, зато наши специалисты<br />
                        смогут получить представление<br />
                        о&nbsp;предстоящих задачах и<br />
                        подготовить варианты решения.</p>
                        <p>Можете не&nbsp;беспокоиться насчет<br />
                        сохранности персональных<br />
                        данных: мы&nbsp;строго соблюдаем<br />
                        политику безопасности и&nbsp;скорее<br />
                        погибнем, чем раскроем<br />
                        информацию.</p>
                </div>
                <div class="right">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'call-form',
	'enableClientValidation'=>true,
	'action'=>'/sendmail',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
                             <input type="hidden" name="formtype" value="contacts" class="formtype"/>
                                <p class="name">
                                        <label for="name">Представьтесь, пожалуйста *</label>
                                        <input type="text" name="name" id="name" placeholder="Достаточно просто имени" class="png_bg" />
                                </p>
                                <p class="phone">
                                        <label for="phone">Номер вашего телефона *</label>
                                        <input type="text" name="phone" id="phone" placeholder="например, 9 928 901-06-48" class="png_bg" />
                                </p>
                                <p class="email">
                                        <label for="email">Адрес электронной почты</label>
                                        <input type="text" name="email" id="email" placeholder="если есть" class="png_bg" />
                                </p>
                                <p class="company_name">
                                        <label for="company_name">Название компании или адрес сайта</label>
                                        <input type="text" name="company_name" id="company_name" placeholder="название компании или адрес сайта" class="png_bg" />
                                </p>

                                <p class="chk_grp clearfix">
                                        <span>По каком вопросу к нам обращаетесь?</span>
                                        <ul>
                                                <li>
                                                        <input type="checkbox" value='разработка сайта' id="chk1" name="chk_grp[]" /><label for="chk1" >разработка сайта</label>
                                                </li>
                                                <li>
                                                        <input type="checkbox" value='реклама в интернете' id="chk2" name="chk_grp[]" /><label for="chk2" >реклама в интернете</label>
                                                </li>
                                                <li>
                                                        <input type="checkbox" value='аудит и анализ работоспособности сайта' id="chk3" name="chk_grp[]" /><label for="chk3" >аудит и анализ работоспособности сайта</label>
                                                </li>
                                                <li>
                                                        <input type="checkbox" value='редизайн сайта' id="chk4" name="chk_grp[]" /><label for="chk4" >редизайн сайта</label>
                                                </li>
                                                <li>
                                                        <input type="checkbox" value='регистрация доменного имени' id="chk5" name="chk_grp[]" /><label for="chk5" >регистрация доменного имени</label>
                                                </li>
                                                <li>
                                                        <input type="checkbox" value='нужен качественный хостинг' id="chk6" name="chk_grp[]" /><label for="chk6" >нужен качественный хостинг</label>
                                                </li>
                                                <li>
                                                        <input type="checkbox" value='корпоративная почта' id="chk7" name="chk_grp[]" /><label for="chk7" >корпоративная почта</label>
                                                </li>
                                        </ul>
                                </p>

                                <p class="clearfix message">
                                        <label for="message">Дополнительная информация *</label>
                                        <textarea name="message" id="message" class="png_bg"></textarea>
                                </p>
                                <?php if(CCaptcha::checkRequirements()): ?>
                                <p class="captcha clearfix">
                                        <label for="captcha">Число на картинке *</label>
                                        <input type="text" id="captcha" name="captcha" placeholder="всего 4 цифры" class="png_bg" />
                                        <?php $this->widget('CCaptcha',array('clickableImage'=>true,'showRefreshButton'=>false,'imageOptions'=>array('width'=>63,'height'=>30,'title'=>'Не вижу картинку'))); ?>
                                </p>
								<?php endif; ?>
                                <p class="submit clearfix">
                                        <input type="submit" value="" onclick="return checkForm();" class="input">
                                        <span>... и с нетерпением жду звонка менеджера</span>
                                </p>
                                <input type="hidden" name="cur_page" value="<?=Yii::app()->params->siteUrl.Yii::app()->request->getUrl()?>"/>
                                <input type="hidden" name="os" value="<?=Yii::app()->browser->getPlatform();?>"/>
                                <input type="hidden" name="browser" value="<?=Yii::app()->browser->getBrowser();?> <?=Yii::app()->browser->getVersion();?>"/>
<?php $this->endWidget(); ?>
                </div>
        </div>
        <div class="clearfix"></div>
</div> <!-- end .order_form -->
