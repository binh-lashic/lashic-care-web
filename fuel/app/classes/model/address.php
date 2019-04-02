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
        $val->add_field('first_name', '', 'required');
        $val->add_field('first_kana', '', 'required|hiragana');
        $val->add_field('last_name', '', 'required');
        $val->add_field('last_kana', '', 'required|hiragana');
        $val->add_field('prefecture', '', 'required');
        $val->add_field('address', '', 'required');
        $val->add_field('phone', '', 'required|valid_string[numeric]');
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