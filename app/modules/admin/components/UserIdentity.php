<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
         
        private $_id;
        
	public function authenticate()
	{
//		$users=array();
//		$UsersData=User::model()->findAll();
//		foreach($UsersData as $key=>$val)
//		{
//			$users[$val->login]=$val->password;
//		}
//		
//		if(!isset($users[$this->username]))
//			$this->errorCode=self::ERROR_USERNAME_INVALID;
//		else if($users[$this->username]!==md5($this->password))
//			$this->errorCode=self::ERROR_PASSWORD_INVALID;
//		else
//			$this->errorCode=self::ERROR_NONE;
//		return !$this->errorCode;
                $login = strtolower($this->username);
                $user = User::model()->find('LOWER(login)=?', array($login));
                if ($user === null)
                    $this->errorCode = self::ERROR_USERNAME_INVALID;
                else if (!$user->validatePassword($this->password))
                    $this->errorCode = self::ERROR_PASSWORD_INVALID;
                else {
                    $this->_id = $user->id;
                    $this->username = $user->login;
                    $this->errorCode = self::ERROR_NONE;
                }
                return $this->errorCode == self::ERROR_NONE;
	}
        
        public function getId()
        {
                return $this->_id;
        }
}
