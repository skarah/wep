		<div class="call png_bg">
    <div class="left">
        <h3>МЫ ВАМ ПЕРЕЗВОНИМ</h3>
        <p>Вам чужды и&nbsp;непонятны<br />
        названия терминов? Оставьте<br />
        номер своего телефона, и&nbsp;вам<br />

        перезвонит человек, который<br />
        все объяснит на&nbsp;понятном<br />
        языке.</p>
    </div>
    <div class="right">
<!--        <form onsubmit="return false">-->
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'call-form',
	'enableClientValidation'=>true,
	'action'=>'/sendmail',
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
 <!--<form action="/sendmail/" method="post" onsubmit="return checkForm()">-->

            <input type="hidden" name="formtype" value="regular" class="formtype"/>
                <table>
                        <tr>
                                <td>
                                        <label for="name">Представьтесь, пожалуйста *</label>
                                <input type="text" name="name" value="" id="name" placeholder="Достаточно просто имени">
                        </td>
                                <td>

                                        <label for="phone">Номер вашего телефона *</label>
                                <input type="text" name="phone" value="" id="phone" placeholder="например, 8 928 901-06-48">
                                </td>
                        </tr>
                        <tr>
                                <td>
                                        <label for="time">В какое время вам перезвонить *</label>
                                <select name="time" id="time" class="ufd">

                                    <option value="c 10:00 до 12:00">c 10:00 до 12:00</option>
                                    <option value="с 14:00 до 17:00">с 14:00 до 17:00</option>
                                </select>
                                </td>
                                <?php if(CCaptcha::checkRequirements()): ?>
                                <td>
                                        <label for="captcha">Число на картинке *</label>
                                <input type="text" id="captcha" name="captcha" placeholder="всего 4 цифры" class="png_bg" />

                                <?php $this->widget('CCaptcha',array('clickableImage'=>true,'showRefreshButton'=>false,'imageOptions'=>array('width'=>63,'height'=>30,'title'=>'Не вижу картинку'))); ?>
                                </td>
                                <?php endif; ?>
                        </tr>
                        <tr>
                                <td colspan="2"><p class="submit">
                                        <input type="submit" value="" onclick="return checkForm();" class="input">
                                        <span>... и с нетерпением жду звонка менеджера</span>
                                </p>
                                <input type="hidden" name="cur_page" value="<?=Yii::app()->params->siteUrl.Yii::app()->request->getUrl()?>"/>
                                <input type="hidden" name="os" value="<?=Yii::app()->browser->getPlatform();?>"/>
                                <input type="hidden" name="browser" value="<?=Yii::app()->browser->getBrowser();?> <?=Yii::app()->browser->getVersion();?>"/>
                                </td>
                        </tr>
                </table>
<?php $this->endWidget(); ?>
    </div>
</div> <!-- end .call form -->	</div>  <!-- end #container -->
