<?php 
class Model_Address extends Orm\Model{

	protected static $_properties = array(
		'id',
        'user_id',
        'last_name',
        'first_name',
        'last_kana',
        'first_kana',
        'zip_code',
        'prefecture',
        'address',
        'phone',
        'updated_at',
        'created_at',
	);
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
        ),
    );
    public static function validate()
    {
        $val = Validation::forge();
        $val->add_callable('Validation_Japanese');
        $val->add_field('first_name', 'お名前 姓', 'required');
        $val->add_field('first_kana', 'ふりがな 姓', 'required|hiragana');
        $val->add_field('last_name', 'お名前 名', 'required');
        $val->add_field('last_kana', 'ふりがな 名', 'required|hiragana');
        $val->add_field('prefecture', '都道府県', 'required');
        $val->add_field('address', '都道府県以下', 'required');
        $val->add_field('phone', '電話番号', 'required|valid_string[numeric]');
        return $val;
    }

    public static function getAddresses($params) {
        return \Model_Address::find("all", array(
            'where' =>  array(
                'user_id' => $params['user_id'],
            )
        ));

    }
}