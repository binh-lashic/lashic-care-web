<?php
class Controller_Api_MonthlyReport extends Controller_Api
{
	/** : 比較対象は過去2~4ヶ月 */
        const MONTHLY_COMPARE_INDEX = 4;
	/** : 評価：良い */
        const MONTHLY_TREND_GOOD = 'good';
        const MONTHLY_TREND_USUALLY = 'usually';
        const MONTHLY_TREND_BAD = 'bad';


	public function before() {
		$this->nologin_methods = array(
			'getTime'
		);
	    parent::before();
	}

	public function post_getTrend() {
		return $this->_getTrend();
	}

	public function get_getTrend() {
		return $this->_getTrend();
	}

	private function _getTrend() {
		list(, $user_id) = Auth::get_user_id();
		$client_user_id = Input::param('user_id');
		$user_client = \Model_User_Client::getUserClient($user_id, $client_user_id);
		if (empty($user_client)) {
			$this->errors[] = array('message' => 'センサーへのアクセスの許可がありません');
        		return $this->result();
		}
		$senosr_id = null;
		$sensor_name = null;
		$bedsensor_name = null;
		$sensors = \Model_Sensor::getSensorsFromClientUserId($client_user_id);
		foreach ($sensors as $sensor) {
			if ($sensor->type == \Model_Sensor::TYPE_SENSOR) {
				$sensor_id = $sensor->id;
				$sensor_name = $sensor->name;
			} else if ($sensor->type == \Model_Sensor::TYPE_BED_SENSOR) {
				$bedsensor_name = $bedsensor_name;
			}
 		}
		if (empty($sensor_name)) {
			$this->errors[] = array('message' => 'センサーが割り当てられていません');
        		return $this->result();
		}
		$data = \Model_Api_Sensors_Monthly::find_by_sensor_name($sensor_name, $bedsensor_name);
	
		$last_monthly;
		$monthlies;
		foreach ($data as $i => $monthly) {
			if ($i == 0) {
				$last_monthly = $monthly;
			} else if ($i < self::MONTHLY_COMPARE_INDEX) {
				$monthlies[] = $monthly;
			}
		}
		if (empty($monthlies)) {
			$this->errors[] = array('message' => '比較するデータがありません');
        		return $this->result();
		}
		$activity = $this->_getTrendActivity($last_monthly, $monthlies);
		$sleep = $this->_getTrendSleep($last_monthly, $monthlies);
		$environment = $this->_getTrendEnvironment($last_monthly, $sensor_id);
		$dementia = $this->_getTrendDementia($last_monthly, $monthlies, $sleep);

		\Log::debug("monthly report. activity:[{$activity}]", __METHOD__);
		\Log::debug("monthly report. sleep:[{$sleep}]", __METHOD__);
		\Log::debug("monthly report. environment:[{$environment}]", __METHOD__);
		\Log::debug("monthly report. dementia:[{$dementia}]", __METHOD__);

		$trends = array(
				'activity' => \Lang::get("trends.activity.{$activity}"),
				'sleep' => \Lang::get("trends.sleep.{$sleep}"),
				'environment' => \Lang::get("trends.environment.{$environment}"),
				'dementia' => \Lang::get("trends.dementia.{$dementia}")
			);
		$this->result = array('trends' => $trends);
		return $this->result; 
	}

	private function _getTrendActivity($last_monthly, $monthlies) {
		// 比較対象の3ヶ月平均運動量を算出
		$avg_activity = 0;
		foreach ($monthlies as $monthly) {
			$avg_activity += $monthly->activity;
		}
		$avg_activity = $avg_activity / count($monthlies);

		$trend_activity;
		// 運動量が20%以上増加している場合は、「良い」
		if ($last_monthly->activity >= $avg_activity * 1.2) {
			$trend_activity = self::MONTHLY_TREND_GOOD;
		// 運動量が20%未満減少している場合は、「普通」
		} else if ($last_monthly->activity > $avg_activity * 0.8) {
			$trend_activity = self::MONTHLY_TREND_USUALLY;
		// 上記意外は、「悪い」
		} else {
			$trend_activity = self::MONTHLY_TREND_BAD;
		}
		return $trend_activity;
	}

	private function _getTrendSleep($last_monthly, $monthlies) {
		// 比較対象の3ヶ月平均睡眠時間を算出
		$avg_sleeping_time = 0;
		$avg_wakeup_time = 0;
		$avg_sleep_time = 0;
		foreach ($monthlies as $monthly) {
			$avg_sleeping_time += $monthly->sleeping_time;
			$avg_wakeup_time += strtotime($monthly->wake_up_time);
			$avg_sleep_time += strtotime($monthly->sleep_time);
		}
		$avg_sleeping_time = $avg_sleeping_time / count($monthlies);
		$avg_wakeup_time = $avg_wakeup_time / count($monthlies);
		$avg_sleep_time = $avg_sleep_time / count($monthlies);

		$trend_sleep;
		// 睡眠時間の増減が1時間未満
		// かつ 起床時間の増減が1時間未満
		// かつ 就寝時間の増減が1時間未満の場合は、「良い」
		if (abs($last_monthly->sleeping_time - $avg_sleeping_time) < 60
		 && abs(strtotime($last_monthly->wake_up_time) - $avg_wakeup_time) < 60 * 60
		 && abs(strtotime($last_monthly->sleep_time) - $avg_sleep_time) < 60 * 60) {
			$trend_sleep = self::MONTHLY_TREND_GOOD;
		// 睡眠時間の増減が2時間未満
		// かつ 起床時間の増減が2時間未満
		// かつ 就寝時間の増減が2時間未満の場合は、「普通」
		} else if (abs($last_monthly->sleeping_time - $avg_sleeping_time) < 2 * 60
		 && abs(strtotime($last_monthly->wake_up_time) - $avg_wakeup_time) < 2 * 60 * 60
		 && abs(strtotime($last_monthly->sleep_time) - $avg_sleep_time) < 2 * 60 * 60) {
			$trend_sleep = self::MONTHLY_TREND_USUALLY;
		// 上記意外は、「悪い」
		} else {
			$trend_sleep = self::MONTHLY_TREND_BAD;
		}
		return $trend_sleep;
	}

	private function _getTrendEnvironment($last_monthly, $sensor_id) {
		$params = array(
				'sensor_id' => $sensor_id,
				'year' => $last_monthly->year,
				'month' => $last_monthly->month
			);
		$alert_count = \Model_Alert::getAlertCountTempAndHumid($params);

		$trend_environment;
		// 気温と湿度のアラートが0件の場合は、「良い」
		if ($alert_count == 0) {
			$trend_environment = self::MONTHLY_TREND_GOOD;
		// 気温と湿度のアラートが20件未満の場合は、「普通」
		} else if ($alert_count < 20) {
			$trend_environment = self::MONTHLY_TREND_USUALLY;
		// 上記以外は、「悪い」
		} else {
			$trend_environment = self::MONTHLY_TREND_BAD;
		}
		return $trend_environment;
	}

	private function _getTrendDementia($last_monthly, $monthlies, $trend_sleep) {
		// 比較対象の3ヶ月平均夜間運動量を算出
		$avg_night_activity = 0;
		foreach ($monthlies as $monthly) {
			$avg_night_activity += $monthly->night_activity;
		}
		$avg_night_activity = $avg_night_activity / count($monthlies);

		$trend_dementia;
		// 夜間運動量が10%未満増加
		// かつ 睡眠レポートが「良い」または「普通」場合は、「良い」
		if ($last_monthly->night_activity < $avg_night_activity * 1.1
		 && $trend_sleep != self::MONTHLY_TREND_BAD) {
			$trend_dementia = self::MONTHLY_TREND_GOOD;
		// 夜間運動量が20%未満増加の場合は、「普通」
		} else if ($last_monthly->night_activity < $avg_night_activity * 1.2) {
			$trend_dementia = self::MONTHLY_TREND_USUALLY;
		// 上記意外は、「悪い」
		} else {
			$trend_dementia = self::MONTHLY_TREND_BAD;
		}
		return $trend_dementia;
	}
}

