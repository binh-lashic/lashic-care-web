<?php
class Presenter_Admin_Licenses_New extends Presenter
{
	public function view()
	{
		$this->licenses = Model_License::get_license_type_name();
		$current_year = (int) date('Y');
		$this->shipping_year  = array_combine(range(2019, $current_year), range(2019, $current_year));
		$this->shipping_month = Config::get("months");
		$this->shipping_date  = Config::get("days");
		$this->status = Model_License_Code::STATUS;
	}
}
