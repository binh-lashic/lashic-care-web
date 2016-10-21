<?php
class Controller_Admin_Billing extends Controller_Admin
{

	public function action_payment()
	{
        if(Input::param("date")) {
            $date = Input::param("date");
        } else {
            $date = date("Y-m-01");
        }

        $data['date'] = $date;
        $data['next_date'] = date("Y-m-01", strtotime($date." +1 month"));
        $data['prev_date'] = date("Y-m-01", strtotime($date." -1 month"));
        
        $sql = "SELECT cp.payment_id,c.id,c.price,c.renew_date,c.user_id,p.title,c.affiliate ".
               "  FROM contracts c ".
               " INNER JOIN plans p ON c.plan_id = p.id ".
               " INNER JOIN contract_payments cp ON c.id = cp.contract_id ".
               " WHERE (c.affiliate IS NULL ".
               "    OR (c.affiliate IS NOT NULL AND c.affiliate != 'magokoro'))".
               "   AND c.renew_date >= :renew_date".
               "   AND c.renew_date < :next_date";

        $query = DB::query($sql);
        $query->parameters(array(
        	'renew_date' => $date,
        	'next_date' => $data['next_date'],
        ));
        $results = $query->execute();

        $contracts = array();
        foreach($results as $result) {
        	if(empty($contracts[$result['payment_id']])) {
	        	$contracts[$result['payment_id']] = $result;
        	}
        	$contracts[$result['payment_id']]['titles'][] = $result['title'];
        	$contracts[$result['payment_id']]['prices'][] = $result['price'];
        }
        $data['contracts'] = $contracts;
        $this->template->title = '継続課金';
        $this->template->content = View::forge('admin/billing/payment', $data);

	}

	public function action_download()
	{
		if(Input::param("date")) {
            $date = Input::param("date");
        } else {
            $date = date("Y-m-01");
        }

        $data['date'] = $date;
        $data['next_date'] = date("Y-m-01", strtotime($date." +1 month"));
        $data['prev_date'] = date("Y-m-01", strtotime($date." -1 month"));
        
        $sql = "SELECT cp.payment_id,c.id,c.price,c.renew_date,c.user_id,p.title,c.affiliate ".
               "  FROM contracts c ".
               " INNER JOIN plans p ON c.plan_id = p.id ".
               " INNER JOIN contract_payments cp ON c.id = cp.contract_id ".
               " WHERE (c.affiliate IS NULL ".
               "    OR (c.affiliate IS NOT NULL AND c.affiliate != 'magokoro'))".
               "   AND c.renew_date >= :renew_date".
               "   AND c.renew_date < :next_date";

        $query = DB::query($sql);
        $query->parameters(array(
        	'renew_date' => $date,
        	'next_date' => $data['next_date'],
        ));
        $results = $query->execute();

        $contracts = array();
        foreach($results as $result) {
        	if(empty($contracts[$result['payment_id']])) {
	        	$contracts[$result['payment_id']] = $result;
        	}
        	$contracts[$result['payment_id']]['titles'][] = $result['title'];
        	$contracts[$result['payment_id']]['prices'][] = $result['price'];
        }

		$i = 0;
		$this->template = null;
		$response = new Response();
		$response->set_header('Content-Type', 'application/csv');
    	$response->set_header('Content-Disposition', 'attachment; filename="'.date("Ym", strtotime($date)).'.csv"');

		foreach($contracts as $contract)
		{
			$i++;

			$params = array(
				$_SERVER['PGCARD_SHOP_ID'], 							//1	ショップID	13	必須	加盟店様を識別する ID【半角英数字】 本サービス契約時に、弊社より発行する値
				$contract['user_id'],									//2	会員ID	60	必須	サイトが管理している会員の ID
				0,														//3	カード登録連番	4		継続課金を行うカードの登録連番 (洗替・継続課金フラグが ON)カードを使用 します。
				0, 														//4	取引コード	1	必須	行う処理を識別するコード 以下のいずれかを設定して下さい。 【0】:売上 【1】:取消
				date('Ymd', mktime(0, 0, 0, date('m', strtotime($date)), 0, date('Y', strtotime($date)))),	//5	利用年月日	8	必須	利用明細に表示される日付 書式は、”yyyymmdd”形式となります。
				$contract['user_id']."-".$contract['id'],				//6	オーダーID	27	必須	加盟店様が取引を識別するための ID【半角英数字、”-“(ハイフン)】
				"0000990",												//7	商品コード	7		設定する際は0000990”を設定して下さい。
				array_sum($contract['prices']),							//8	利用金額	7	必須	商品に対する金額 税送料を指定していない場合は、決済金額となります。 税送料を指定している場合は、利用金額+税送料が決済金額となり ます。
				array_sum($contract['prices']) * Config::get("tax"),	//9	税送料	7		商品とは異なる送料等の金額
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
}
?>