 <div id="mail-form">
    <div class="main_form_container">
            <div class="left">

                    <h2>Напишите нам письмо</h2>
                    <p>Не&nbsp;любите болтать по&nbsp;телефону?</p>
                    <p>Напишите нам сообщение и<br />
                    расскажите о&nbsp;своей проблеме.<br />
                    Мы&nbsp;все обдумаем и&nbsp;прадоставим<br />

                    вам обдуманный вариант<br />
                    решения или даже рассчитаем<br />
                    примерный бюджет будущего<br />
                    проекта. Звонок по&nbsp;телефону<br />
                    таких преимуществ не&nbsp;дает.</p>

                    <p>Большая просьба продоставлять<br />
                    правильные контактные<br />
                    данные, иначе мы&nbsp;просто не<br />
                    сможем с&nbsp;вами связаться.<br />
                    Обязательно заполните все поля<br />

                    со&nbsp;звездочкой.</p>
            </div>
            <div class="right">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'main-form',
	'enableClientValidation'=>true,
	'action'=>'/sendmail',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
                        <input type="hidden" name="formtype" value="mainpage" class="formtype"/>
                            <table>
                                    <tr>
                                            <td colspan="2">

                                                    <label for="name">Представьтесь, пожалуйста *</label>
                                    <input type="text" name="name" id="name" placeholder="Достаточно просто имени" class="png_bg" />
                                            </td>
                                    </tr>
                                    <tr>
                                            <td>
                                                    <label for="phone">Номер вашего телефона *</label>
                                    <input type="text" name="phone" id="phone" placeholder="например, 9 928 901-06-48" class="png_bg" />

                                            </td>
                                            <td>
                                                    <label for="email">Адрес электронной почты</label>
                                    <input type="text" name="email" id="email" placeholder="если есть" class="png_bg" />
                                            </td>
                                    </tr>
                                    <tr>
                                            <td colspan="2">

                                                    <label for="message">Текст сообщения *</label>
                                    <textarea name="message" id="message" class="png_bg"></textarea>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td class="captcha" colspan="2">
                                                    <label for="captcha">Число на картинке *</label>

                                    <input type="text" id="captcha" name="captcha" placeholder="всего 4 цифры" class="png_bg" />
                                    <?php $this->widget('CCaptcha',array('clickableImage'=>true,'showRefreshButton'=>false,'imageOptions'=>array('width'=>63,'height'=>30,'title'=>'Не вижу картинку'))); ?>
                                            </td>
                                            <td class="captcha_img">
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="submit clearfix"><input type="submit" value="" onclick="return checkForm();" class="input"></p>
                                <input type="hidden" name="cur_page" value="<?=Yii::app()->params->siteUrl.Yii::app()->request->getUrl()?>"/>
                                <input type="hidden" name="os" value="<?=Yii::app()->browser->getPlatform();?>"/>
                                <input type="hidden" name="browser" value="<?=Yii::app()->browser->getBrowser();?> <?=Yii::app()->browser->getVersion();?>"/>
                                        </td></tr>
                            </table>
<?php $this->endWidget(); ?>
            </div>
    </div>
</div>
