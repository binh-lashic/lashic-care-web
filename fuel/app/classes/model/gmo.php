<?php 
require_once(APPPATH.'config.php');
set_include_path(get_include_path().PATH_SEPARATOR.APPPATH);

class Model_GMO extends Orm\Model{

	public static function findMember($id) {
		\Autoloader::add_class('SearchMemberInput', APPPATH.'com/gmo_pg/client/input/SearchMemberInput.php');
		\Autoloader::add_class('SearchMember', APPPATH.'com/gmo_pg/client/tran/SearchMember.php');

		$input = new SearchMemberInput();
		$input->setSiteId( PGCARD_SITE_ID );
		$input->setSitePass( PGCARD_SITE_PASS );
		$input->setMemberId( $id );
		$exe = new SearchMember();
		$output = $exe->exec( $input );
		if( $exe->isExceptionOccured() ){
			require_once( PGCARD_SAMPLE_BASE . '/display/Exception.php');
			exit();
		}else{
			if( $output->isErrorOccurred() ){
				require_once( PGCARD_SAMPLE_BASE . '/display/Error.php');
				exit();
			} else if($output->memberId) {
				return $output;
			}
			return null;
		}
	}

	public static function saveMember($id) {
		\Autoloader::add_class('SaveMemberInput', APPPATH.'com/gmo_pg/client/input/SaveMemberInput.php');
		\Autoloader::add_class('SaveMember', APPPATH.'com/gmo_pg/client/tran/SaveMember.php');

		$input = new SaveMemberInput();
		$input->setSiteId( PGCARD_SITE_ID );
		$input->setSitePass( PGCARD_SITE_PASS );
		
		$input->setMemberId( $id );
		
		//$input->setMemberName( mb_convert_encoding( $_POST['MemberName'] , 'SJIS' , PGCARD_SAMPLE_ENCODING ) );
		
		$exe = new SaveMember();
		$output = $exe->exec( $input );
		if( $exe->isExceptionOccured() ){
			echo "isExceptionOccured";
			echo "\n";
			$exception = $exe->getException(); 
			echo $exception->getMessage();
			echo "\n";
			$mesasges = $exception->getMessages();
			foreach($messages as $message) {
				echo $message;
				echo "\n";
			}
			return $output;		
		}else{
			if( $output->isErrorOccurred() ){
				require_once( PGCARD_SAMPLE_BASE . '/display/Error.php');
				exit();
			} else if($output->memberId) {
				return true;
			}
			return $output;
		}
	}

	public static function findCard($params) {
		\Autoloader::add_class('SearchCardInput', APPPATH.'com/gmo_pg/client/input/SearchCardInput.php');
		\Autoloader::add_class('SearchCard', APPPATH.'com/gmo_pg/client/tran/SearchCard.php');

		$input = new SearchCardInput();/* @var $input SearchCardInput */
		$input->setSiteId( PGCARD_SITE_ID );
		$input->setSitePass( PGCARD_SITE_PASS );
		
		$input->setMemberId( $params['member_id'] );
		/*
		$cardSeq = $params['CardSeq'];
		if( 0 < strlen( $cardSeq ) ){
			//登録カード連番
			$input->setCardSeq( $cardSeq );
			$input->setSeqMode( $params['SeqMode'] );	
		}*/
		
		$exe = new SearchCard();/* @var $exec SearchCard */
		$output = $exe->exec( $input );/* @var $output SearchCardOutput */
		if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			require_once( PGCARD_SAMPLE_BASE . '/display/Exception.php');
			exit();
		}else{
			if( $output->isErrorOccurred() ){//出力パラメータにエラーコードが含まれていないか、チェックしています。
				require_once( PGCARD_SAMPLE_BASE . '/display/Error.php');
				exit();
			}
			return $output;
		}
	}
	public static function saveCard($params) {
		\Autoloader::add_class('SaveCardInput', APPPATH.'com/gmo_pg/client/input/SaveCardInput.php');
		\Autoloader::add_class('SaveCard', APPPATH.'com/gmo_pg/client/tran/SaveCard.php');

		$input = new SaveCardInput();/* @var $input SaveCardInput */
		$input->setSiteId( PGCARD_SITE_ID );
		$input->setSitePass( PGCARD_SITE_PASS );

		$input->setMemberId( $params['member_id'] );
		$input->setCardNo( $params['number'] );
		//$input->setCardPass( $params['CardPass'] );
		$input->setExpire( $params['expire'] );
		$input->setHolderName( $params['holder_name']);
/*
		$cardSeq = $_POST['CardSeq'];
		if( 0 < strlen( $cardSeq ) ){
			//登録カード連番
			$input->setCardSeq( $cardSeq );
			$input->setSeqMode( $_POST['SeqMode'] );
		}
*/
/*
		$token = $_POST['Token'];
		if( 0 < strlen( $token ) )
		{
			$input->setToken( $_POST['Token']);
		}else{
			$input->setCardNo( $_POST['CardNo'] );
			$input->setCardPass( $_POST['CardPass'] );
			$input->setExpire( $_POST['Expire'] );
			$input->setHolderName( $_POST['HolderName']);
		}
		$input->setCardName( $_POST['CardName']);
		$input->setDefaultFlag( $_POST['DefaultFlag']);
*/

		$exe = new SaveCard();/* @var $exec SearchCard */
		$output = $exe->exec( $input );/* @var $output SaveCardOutput */
		if( $exe->isExceptionOccured() ){//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			echo "isExceptionOccured";
			echo "\n";
			$exception = $exe->getException(); 
			echo $exception->getMessage();
			echo "\n";
			$mesasges = $exception->getMessages();
			foreach($messages as $message) {
				echo $message;
				echo "\n";
			}
			return $output;
		}else{
			if( $output->isErrorOccurred() ){//出力パラメータにエラーコードが含まれていないか、チェックしています。
				//サンプルでは、エラーが発生していた場合、エラー画面を表示して終了します。
				echo "isErrorOccurred";
				$errorList = $output->getErrList() ;
				
				foreach( $errorList as  $errorInfo ){
					echo '<p>'
						. $errorInfo->getErrCode()
						. ':' . $errorInfo->getErrInfo()
						.'</p>';
						
				}
				return $output;
			}
		}
	}

	public static function exec($params) {
		\Autoloader::add_class('EntryTranInput', APPPATH.'com/gmo_pg/client/input/EntryTranInput.php');
		\Autoloader::add_class('ExecTranInput', APPPATH.'com/gmo_pg/client/input/ExecTranInput.php');
		\Autoloader::add_class('EntryExecTranInput', APPPATH.'com/gmo_pg/client/input/EntryExecTranInput.php');
		\Autoloader::add_class('EntryExecTran', APPPATH.'com/gmo_pg/client/tran/EntryExecTran.php');
		//入力パラメータクラスをインスタンス化します
		
		if(empty($params['order_id'])) {
			$order_id = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 1);
		} else {
			$order_id = $params['order_id'];
		}
		echo $order_id;

		//取引登録時に必要なパラメータ
		$entryInput = new EntryTranInput();
		$entryInput->setShopId( PGCARD_SHOP_ID );
		$entryInput->setShopPass( PGCARD_SHOP_PASS );
		$entryInput->setJobCd("CAPTURE");
		$entryInput->setItemCode( "0000990" );
		$entryInput->setAmount( $params['amount']);
		$entryInput->setTax( $params['tax']);
		$entryInput->setOrderId( $order_id );
		
		$execInput = new ExecTranInput();							//決済実行のパラメータ
		$execInput->setOrderId( $order_id );						//カード番号入力型・会員ID決済型に共通する値です。
		$execInput->setMethod( 1 );									//支払方法に応じて、支払回数のセット要否が異なります。
		$execInput->setCardNo( $params['number'] );
		$execInput->setExpire( $params['expire'] );
		$execInput->setSecurityCode( $params['security_code'] );	//セキュリティコードは任意です。
		
		//取引登録＋決済実行の入力パラメータクラスをインスタンス化します
		$input = new EntryExecTranInput();
		$input->setEntryTranInput( $entryInput );
		$input->setExecTranInput( $execInput );
		
		$exe = new EntryExecTran();
		$output = $exe->exec( $input );
		
		if( $exe->isExceptionOccured() )
		{//取引の処理そのものがうまくいかない（通信エラー等）場合、例外が発生します。
			echo "isExceptionOccured";
			echo "\n";
			$exception = $exe->getException(); 
			echo $exception->getMessage();
			echo "\n";
			$mesasges = $exception->getMessages();
			foreach($messages as $message) {
				echo $message;
				echo "\n";
			}
			return $output;			
		}
		else
		{
			//例外が発生していない場合、出力パラメータオブジェクトが戻ります。
			if( $output->isErrorOccurred() )
			{//出力パラメータにエラーコードが含まれていないか、チェックしています。
				//サンプルでは、エラーが発生していた場合、エラー画面を表示して終了します。
				echo "isErrorOccurred";
				if( $output->isEntryErrorOccurred()  ){
					$errorList = $output->getEntryErrList() ;
				} else {
					$errorList = $output->getExecErrList();	
				}
				foreach( $errorList as  $errorInfo ){
					echo '<p>'
						. $errorInfo->getErrCode()
						. ':' . $errorInfo->getErrInfo()
						.'</p>';
						
				}
				return $output;
			}
			return $output;
		}
	}
}