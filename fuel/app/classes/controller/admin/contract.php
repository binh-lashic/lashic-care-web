<?php
class Controller_Admin_Contract extends Controller_Admin
{

	public function action_list()
	{
		$data['contracts'] = \Model_Contract::getSearch();
        $this->template->title = '契約一覧';
        $this->template->content = View::forge('admin/contract/list', $data);
	}

	public function action_laundering()
	{
		$this->template = null;
		$response = new Response();
		$response->set_header('Content-Type', 'application/csv');
    	$response->set_header("Content-Disposition", "attachment; filename=laundering.csv");

		$users = \Model_Contract::getUsers();
		foreach($users as $user)
		{
			$params = array(
				$user,
				0,
				"",
			);
			echo "\"".Implode("\",\"", $params)."\"\n";
		}
		return $response;
	}

	public function action_payment()
	{
		$contracts = \Model_Contract::getSearch();
		$i = 0;
		$this->template = null;
		$response = new Response();
		$response->set_header('Content-Type', 'application/csv');
    	$response->set_header('Content-Disposition', 'attachment; filename="'.date("Ym").'.csv"');

		foreach($contracts as $contract)
		{
			$i++;

			$params = array(
				$_SERVER['PGCARD_SHOP_ID'], 							//1	ショップID	13	必須	加盟店様を識別する ID【半角英数字】 本サービス契約時に、弊社より発行する値
				$contract['user_id'],									//2	会員ID	60	必須	サイトが管理している会員の ID
				0,														//3	カード登録連番	4		継続課金を行うカードの登録連番 (洗替・継続課金フラグが ON)カードを使用 します。
				0, 														//4	取引コード	1	必須	行う処理を識別するコード 以下のいずれかを設定して下さい。 【0】:売上 【1】:取消
				date('Ymd', mktime(0, 0, 0, date('m'), 0, date('Y'))),	//5	利用年月日	8	必須	利用明細に表示される日付 書式は、”yyyymmdd”形式となります。
				$contract['user_id']."-".$contract['id'],				//6	オーダーID	27	必須	加盟店様が取引を識別するための ID【半角英数字、”-“(ハイフン)】
				"0000990",												//7	商品コード	7		設定する際は0000990”を設定して下さい。
				$contract['price'],										//8	利用金額	7	必須	商品に対する金額 税送料を指定していない場合は、決済金額となります。 税送料を指定している場合は、利用金額+税送料が決済金額となり ます。
				0,														//9	税送料	7		商品とは異なる送料等の金額
				1,														//10	支払方法	1	必須	決済を行う際の支払方法 以下を設定してください。 【1】:一括
				"",														//11	予備			””固定
				"",														//12	予備			””固定
				"",														//13	予備			””固定
				sprintf("%05d",$i),										//14	端末処理通番	5	必須	原則的にユニークとなる 5 桁の値 “00001”からの通番で構いません。 また、”99999”を超える場合に、再度”00001”からで構いません。
				"",														//15	加盟店自由項目	50		加盟店様が自由に設定出来る項目 半角英数記号(一部除く）と全角文字が使用可能
				"",														//16	処理番号			結果用項目 “”固定
				"",														//17	処理結果			結果用項目 “”固定
				"",														//18	仕向先コード			結果用項目 “”固定
				"",														//19	オーソリ結果			結果用項目 “”固定
			);
			$csv = "\"".Implode("\",\"", $params)."\"\n";
			echo mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
		}
		return $response;
	}

    public function action_add_sensor() {
        $contract = \Model_Contract::find(Input::param("contract_id"));


        $sensor_names_data = Input::param("sensor_names");
        $sensor_names = explode(PHP_EOL, $sensor_names_data);

        if($contract['id'] && $sensor_names) {
            foreach($sensor_names as $name) {
                $name = trim($name);
                //センサーを新規登録
                $sensor = Model_Sensor::find("first" , array(
                    'where' => array(
                            array('name', $name),
                        )
                    ));
                if(!$sensor) {
                    $sensor = Model_Sensor::forge();
                    $sensor->set(array('name' => $name));
                    $sensor->save();
                }

                if($sensor->id > 0) {
                	\Model_Contract_Sensor::saveContractSensor(array(
                        'contract_id' => $contract['id'],
                        'sensor_id' => $sensor->id,
                    ));

                    //見守られユーザを登録
                    \Model_User_Client::saveUserClient(array(
                        'user_id' => $contract['user_id'],
                        'client_user_id' => $contract['client_user_id'],
                    ));

                    //管理者として登録
                    \Model_User_Sensor::saveUserSensor(array(
                        'user_id' => $contract['client_user_id'],
                        'sensor_id' => $sensor->id,
                        'admin' => 0,
                    ));

                    //管理者として登録
                    \Model_User_Sensor::saveUserSensor(array(
                        'user_id' => $contract['user_id'],
                        'sensor_id' => $sensor->id,
                        'admin' => 1,
                    ));
                }

            }
	        Response::redirect('/admin/contract/sensor?id='.$contract['id']);
    	}
    }
}
?>