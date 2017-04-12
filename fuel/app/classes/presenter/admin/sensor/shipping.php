<?php
class Presenter_Admin_Sensor_Shipping extends Presenter
{
	public function view()
	{
		$sensor_id = Input::param("id");
		$this->sensor = \Model_Sensor::find($sensor_id);

		// センサーが取得できなかった場合は 404
		if (!isset($this->sensor)) {
			throw new HttpNotFoundException;
		}
		Log::debug("sensor_id:[{$this->sensor->id}] sensor_name:[{$this->sensor->name}]", __METHOD__);


		$current_year = (int) date('Y');
		$this->shipping_years  = array_combine(range(2016, $current_year), range(2016, $current_year));
		$this->shipping_months = Config::get("months");
		$this->shipping_days   = Config::get("days");

		if ($this->sensor->shipping_date) {
			$this->year  = Input::post('shipping_year')  ? Input::post('shipping_year')  : date("Y", strtotime($this->sensor->shipping_date));
			$this->month = Input::post('shipping_month') ? Input::post('shipping_month') : date("n", strtotime($this->sensor->shipping_date));
			$this->day   = Input::post('shipping_day')   ? Input::post('shipping_day')   : date("j", strtotime($this->sensor->shipping_date));
		} else {
			$now = time();
			$this->year  = Input::post('shipping_year')  ? Input::post('shipping_year')  : date("Y", $now);
			$this->month = Input::post('shipping_month') ? Input::post('shipping_month') : date("n", $now);
			$this->day   = Input::post('shipping_day')   ? Input::post('shipping_day')   : date("j", $now);
		}
	}
}
