<?php

use Fuel\Core\TestCase;

class Test_Util_Datetime extends TestCase
{
	/**
	 * @test
	 * @dataProvider get_datetime
	 * @param $datetime
	 * @param $expected_is_today
	 */
	public function is_today($datetime, $expected_is_today)
	{
		$is_today = Util_Datetime::is_today($datetime);
		$this->assertSame($expected_is_today, $is_today);
	}

	public function get_datetime()
	{
		return [
			['datetime' => new DateTime('now'), 'is_today' => true],
			['datetime' => new DateTime('+1 day'), 'is_today' => false],
			['datetime' => new DateTime('-1 day'), 'is_today' => false],
		];
	}

}
