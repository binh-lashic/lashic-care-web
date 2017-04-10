<?php

use Fuel\Core\TestCase;

class Test_Util_Datetime extends TestCase
{
	/**
	 * @test
	 * @dataProvider provide_is_today_data
	 * @param $datetime
	 * @param $expected_is_today
	 */
	public function is_today($datetime, $expected_is_today)
	{
		$is_today = Util_Datetime::is_today($datetime);
		$this->assertSame($expected_is_today, $is_today);
	}

	public function provide_is_today_data()
	{
		return [
			['datetime' => new DateTime('now'), 'is_today' => true],
			['datetime' => new DateTime('+1 day'), 'is_today' => false],
			['datetime' => new DateTime('-1 day'), 'is_today' => false],
		];
	}

	/**
	 * @test
	 * @dataProvider provide_to_datetime_data
	 * @param $date
	 */
	public function to_datetime($date) {
		$datetime = Util_Datetime::to_datetime($date);
		$this->assertInstanceOf(DateTime::class, $datetime);
	}

	public function provide_to_datetime_data()
	{
		return [
			['date' => new DateTime('now')],
			['date' => '2017-01-01'],
			['date' => '2017-01-01 23:59:59'],
		];
	}

	/**
	 * @test
	 * @dataProvider provide_is_same_day_data
	 * @param $date1
	 * @param $date2
	 * @param $expected
	 */
	public function is_same_day($date1, $date2, $expected)
	{
		$is_same = Util_Datetime::is_same_day($date1, $date2);
		$this->assertSame($expected, $is_same);
	}

	public function provide_is_same_day_data()
	{
		return [
			['date1' => new DateTime('now'),   'date2' => new DateTime('now'),    'expected' => true],
			['date1' => '2017-01-01',          'date2' => '2017-01-01',           'expected' => true],
			['date1' => '2017-01-01 00:00:00', 'date2' => '2017-01-01 23:59:59',  'expected' => true],
			['date1' => new DateTime('now'),   'date2' => new DateTime('+1 day'), 'expected' => false],
		];
	}
}
