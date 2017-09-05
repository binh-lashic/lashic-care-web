<?php
/*
 * ユーザ登録フォーム Trait
 * 親アカウント、見守られユーザー登録共通で利用しています。
 */
trait Trait_Admin_User_Regist
{
        /*
         * ユーザ情報取得
         *  
         * @access public.static
         * @params int $id
         * @return array
         */
        public static function getUser($id)
        {
            try {
                return Model_User::getUser($id);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }           
        }
        
        /*
         * Configから選択肢を取得
         * 
         * @access public.static
         * @param array $target
         * @reutrn array $list
         */
        public static function getConfig(array $target=['gender','eras', 'months', 'days', 'blood_type', 'prefectures'])
        {
            $list = [];
            foreach($target as $value) {
                $list[$value] = Config::get($value);
            }
            return $list;
        }
        
        /*
         * 選択名を取得 
         * 
         * @access public.static
         * @param string $name 'gender','eras', 'months', 'days', 'blood_type', 'prefectures'
         * @return bool
         */
        public static function getSelectedName($name, $selected)
        {
            $list = Config::get($name);
            return ($list[$selected]) ?: '';
        }
        
        /*
         * 日付型へ変換 
         * 
         * @access public.static
         * @param int $year
         * @param int $month
         * @param int $day
         * @return date
         */
        public static function convert2DateFormat($year, $month, $day)
        {
            return sprintf('%d-%02d-%02d', $year, $month, $day);
        }
        
        /*
         * データを整形 
         * 
         * @access private.static
         * @param array $params
         * @param bool $isExcludeId
         * return array $data
         */
        private static function setData(array $params=[], $isExcludeId=true)
        {
            $data = Input::param();
            $data['birthday'] = self::convert2DateFormat($data['year'], $data['month'], $data['day']);
            $data['prefecture'] = self::getSelectedName('prefectures', $data['prefecture']);
            if(isset($params['admin'])) {
                $data['admin'] = $params['admin'];
            }
            if(isset($params['email_confirm'])) {
                $data['email_confirm'] = $params['email_confirm'];
            }
            
            if ($isExcludeId) {
                unset($data['id']);
            }

            return $data;
        }
        
        /*
         * 親ユーザ登録用にデータを整形
         * users.email_confirm = 1(本登録)で登録
         * 
         * @param none
         */
        public static function setDataByAdmin()
        {
            return self::setData(['email_confirm' => 1]);
        }
        
        /*
         * 見守りユーザ登録用にデータを整形
         * 
         * @param none
         */
        public static function setDataByClient()
        {
            return self::setData(['admin' => 0]);
        }
}