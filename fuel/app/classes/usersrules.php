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
}