<?php
/*
 * UsersバリデーションClass
 */
class UsersRules
{
    /*
     * 郵便番号の整合性チェック
     * 
     *  @param int $value
     *  @return boolean
     */
    public static function _validation_check_zipcode($value)
    {
        if($value) {
            if(preg_match('/^[0-9]{7}$/', $value)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
    
    /*
     * 電話番号の整合チェック 
     * 
     * @param int $value
     * @return boolean
     */
    public static function _validation_check_phone($value)
    {
        if($value) {
            if(preg_match('/^[0-9]{10,11}$/', $value)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
    
    /*
     * メールアドレスの整合性チェック 
     * 
     * @param string $value
     * @return boolean
     */
    public static function _validation_check_email($value)
    {
        if($value) {
            if(filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
    
    /*
     * メールアドレスの重複チェック 
     * 
     * @param string $value
     * @return boolean
     */
    public static function _validation_duplicate_email($value)
    {
        $result = Model_User::getUserFromEmail($value);
        if(is_null($result)) {
            return true;
        }
        return false;
    }
  
    /*
     * 仮メールアドレスの存在チェック
     *
     * @param string $value
     * @return boolean
     */
      public static function _validation_exist_temp_email($value)
      {
        return !is_null(Model_User::getTempUserFromEmail($value));
      }
      
    /*
     * メールアドレスとメールアドレス（確認）を比較の為
     * 
     * @param string $email_confirm
     * @param string $email
     * @return bool
     */
    public static function _validation_check_confirm_email($email_confirm, $email)
    {
        if($email_confirm == $email) {
            return true;
        }
        return false;
    }
    
    /*
     * 入力されたパスワードが妥当かをチェック
     *  
     * @param string $password
     * @param int $id
     * @return bool
     */
    public static function _validation_check_password($password, $id)
    {
        if($password && $id) {
            $result = Model_User::find('first',[
                            'where' => [
                                'id' => $id,
                                'password' => Auth::hash_password($password)
                            ]
                        ]);         
            if($result) {
                return true;
            }
        }
        return false;
    }
    
    /*
     * 新パスワードと新パスワード(確認)の整合性チェック
     * 
     * @param string $new_password_confirm
     * @param string $new_password
     * @return bool
     */
    public static function _validation_check_confirm_password($new_password_confirm, $new_password)
    {
        if($new_password_confirm == $new_password) {
            return true;
        }
        return false;
    }
}