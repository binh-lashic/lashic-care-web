<?php
require_once(APPPATH.'config.php');
\Autoloader::add_class('EntryTranInput', APPPATH.'com/gmo_pg/client/input/EntryTranInput.php');
\Autoloader::add_class('ExecTranInput', APPPATH.'com/gmo_pg/client/input/ExecTranInput.php');
\Autoloader::add_class('EntryExecTranInput', APPPATH.'com/gmo_pg/client/input/EntryExecTranInput.php');
\Autoloader::add_class('EntryExecTran', APPPATH.'com/gmo_pg/client/tran/EntryExecTran.php');

class Controller_Api_Gmo extends Controller_Api
{

	function get_index() {
		if(Input::param()){
			//入力パラメータクラスをインスタンス化します
			
			//取引登録時に必要なパラメータ
			$entryInput = new EntryTranInput();
			$entryInput->setShopId( PGCARD_SHOP_ID );
			$entryInput->setShopPass( PGCARD_SHOP_PASS );
			$entryInput->setJobCd("CAPTURE");
			$entryInput->setItemCode( "0000990" );

			$entryInput->setAmount( Input::param('Amount'));
			$entryInput->setTax( Input::param('Tax'));
			$entryInput->setOrderId( Input::param('OrderID') );
			
			//決済実行のパラメータ
			$execInput = new ExecTranInput();

			//カード番号入力型・会員ID決済型に共通する値です。
			$execInput->setOrderId( Input::param('OrderID') );
			
			//支払方法に応じて、支払回数のセット要否が異なります。
			$execInput->setMethod( 1 );

			//カード番号・有効期限は必須です。
			$execInput->setCardNo( Input::param('CardNo') );
			$execInput->setExpire( Input::param('Expire') );
			
			//セキュリティコードは任意です。
			$execInput->setSecurityCode( Input::param('SecurityCode') );
			
			//取引登録＋決済実行の入力パラメータクラスをインスタンス化します
			$input = new EntryExecTranInput();
			$input->setEntryTranInput( $entryInput );
			$input->setExecTranInput( $execInput );
			
			$exe = new EntryExecTran();
			$output = $exe->exec( $input );

			//実行後、その結果を確認します。
			
			if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。

				//サンプルでは、例外メッセージを表示して終了します。
				exit();
				
			}else{
				
				//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
				
				if( $output->isErrorOccurred() ){//出力パラメータにエラーコードが含まれていないか、チェックしています。
					
					//サンプルでは、エラーが発生していた場合、エラー画面を表示して終了します。
					exit();
					
				}
				print_r($output);
				//例外発生せず、エラーの戻りもなく、3Dセキュアフラグもオフであるので、実行結果を表示します。
			}
			
		}
	}
}
?>