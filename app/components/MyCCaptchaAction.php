<?php
class MyCCaptchaAction extends CCaptchaAction
{
    /**
     * Generates a new verification code.
     * @return string the generated verification code
     */
    protected function generateVerifyCode()
    {
		/*
        if($this->minLength<4)
            $this->minLength=4;
        if($this->maxLength>4)
            $this->maxLength=4;
        if($this->minLength>$this->maxLength)
            $this->maxLength=$this->minLength;
        $length=rand($this->minLength,$this->maxLength);
		*/
		$length=4;
        // Тут указываем символы которые будут 
        // выводится у нас на капче. 
        $letters='1234567890';
        $code='';
        for($i=0;$i<$length;++$i)
        {
            $code.=$letters[rand(0, strlen($letters)-1)];
        }
        return $code;
    }
}
