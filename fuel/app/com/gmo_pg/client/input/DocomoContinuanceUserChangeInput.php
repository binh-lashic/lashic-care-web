<?php
require_once ('com/gmo_pg/client/input/BaseInput.php');
/**
 * <b>ドコモ継続決済　継続課金変更(お客様)　入力パラメータクラス</b>
 *
 * @package com.gmo_pg.client
 * @subpackage input
 * @see inputPackageInfo.php
 * @author GMO PaymentGateway
 * @version 1.0
 * @created 2012/08/21
 */
class DocomoContinuanceUserChangeInput extends BaseInput {

	/**
	 * @var string ショップID
	 */
	var $shopID;

	/**
	 * @var string ショップパスワード
	 */
	var $shopPass;

	/**
	 * @var string 取引ID
	 */
	var $accessID;

	/**
	 * @var string 取引パスワード
	 */
	var $accessPass;

	/**
	 * @var string オーダーID
	 */
	var $orderID;

	/**
	 * @var string 利用金額
	 */
	var $amount;

	/**
	 * @var string 税送料
	 */
	var $tax;

	/**
	 * @var string ドコモ表示項目1
	 */
	var $docomoDisp1;

	/**
	 * @var string ドコモ表示項目2
	 */
	var $docomoDisp2;

	/**
	 * @var string 決済結果戻しURL
	 */
	var $retURL;

	/**
	 * @var string 支払開始期限秒
	 */
	var $paymentTermSec;


	/**
	 * コンストラクタ
	 *
	 * @param array $params 入力パラメータ
	 */
	function DocomoContinuanceUserChangeInput($params = null) {
		$this->__construct($params);
	}

	/**
	 * コンストラクタ
	 *
	 * @param array $params 入力パラメータ
	 */
	function __construct($params = null) {
		parent::__construct($params);
	}


	/**
	 * ショップID取得
	 * @return string ショップID
	 */
	function getShopID() {
		return $this->shopID;
	}

	/**
	 * ショップパスワード取得
	 * @return string ショップパスワード
	 */
	function getShopPass() {
		return $this->shopPass;
	}

	/**
	 * 取引ID取得
	 * @return string 取引ID
	 */
	function getAccessID() {
		return $this->accessID;
	}

	/**
	 * 取引パスワード取得
	 * @return string 取引パスワード
	 */
	function getAccessPass() {
		return $this->accessPass;
	}

	/**
	 * オーダーID取得
	 * @return string オーダーID
	 */
	function getOrderID() {
		return $this->orderID;
	}

	/**
	 * 利用金額取得
	 * @return integer 利用金額
	 */
	function getAmount() {
		return $this->amount;
	}

	/**
	 * 税送料取得
	 * @return integer 税送料
	 */
	function getTax() {
		return $this->tax;
	}

	/**
	 * ドコモ表示項目1取得
	 * @return string ドコモ表示項目1
	 */
	function getDocomoDisp1() {
		return $this->docomoDisp1;
	}

	/**
	 * ドコモ表示項目2取得
	 * @return string ドコモ表示項目2
	 */
	function getDocomoDisp2() {
		return $this->docomoDisp2;
	}

	/**
	 * 決済結果戻しURL取得
	 * @return string 決済結果戻しURL
	 */
	function getRetURL() {
		return $this->retURL;
	}

	/**
	 * 支払開始期限秒取得
	 * @return integer 支払開始期限秒
	 */
	function getPaymentTermSec() {
		return $this->paymentTermSec;
	}

	/**
	 * ショップID設定
	 *
	 * @param string $shopID
	 */
	function setShopID($shopID) {
		$this->shopID = $shopID;
	}

	/**
	 * ショップパスワード設定
	 *
	 * @param string $shopPass
	 */
	function setShopPass($shopPass) {
		$this->shopPass = $shopPass;
	}

	/**
	 * 取引ID設定
	 *
	 * @param string $accessID
	 */
	function setAccessID($accessID) {
		$this->accessID = $accessID;
	}

	/**
	 * 取引パスワード設定
	 *
	 * @param string $accessPass
	 */
	function setAccessPass($accessPass) {
		$this->accessPass = $accessPass;
	}

	/**
	 * オーダーID設定
	 *
	 * @param string $orderID
	 */
	function setOrderID($orderID) {
		$this->orderID = $orderID;
	}

	/**
	 * 利用金額設定
	 *
	 * @param integer $amount
	 */
	function setAmount($amount) {
		$this->amount = $amount;
	}

	/**
	 * 税送料設定
	 *
	 * @param integer $tax
	 */
	function setTax($tax) {
		$this->tax = $tax;
	}

	/**
	 * ドコモ表示項目1設定
	 *
	 * @param string $docomoDisp1
	 */
	function setDocomoDisp1($docomoDisp1) {
		$this->docomoDisp1 = $docomoDisp1;
	}

	/**
	 * ドコモ表示項目2設定
	 *
	 * @param string $docomoDisp2
	 */
	function setDocomoDisp2($docomoDisp2) {
		$this->docomoDisp2 = $docomoDisp2;
	}

	/**
	 * 決済結果戻しURL設定
	 *
	 * @param string $retURL
	 */
	function setRetURL($retURL) {
		$this->retURL = $retURL;
	}

	/**
	 * 支払開始期限秒設定
	 *
	 * @param integer $paymentTermSec
	 */
	function setPaymentTermSec($paymentTermSec) {
		$this->paymentTermSec = $paymentTermSec;
	}


	/**
	 * デフォルト値設定
	 */
	function setDefaultValues() {

	}

	/**
	 * 入力パラメータ群の値を設定する
	 *
	 * @param IgnoreCaseMap $params 入力パラメータ
	 */
	function setInputValues($params) {
		// 入力パラメータがnullの場合は設定処理を行わない
	    if (is_null($params)) {
	        return;
	    }

	    $this->setShopID($this->getStringValue($params, 'ShopID', $this->getShopID()));
	    $this->setShopPass($this->getStringValue($params, 'ShopPass', $this->getShopPass()));
	    $this->setAccessID($this->getStringValue($params, 'AccessID', $this->getAccessID()));
	    $this->setAccessPass($this->getStringValue($params, 'AccessPass', $this->getAccessPass()));
	    $this->setOrderID($this->getStringValue($params, 'OrderID', $this->getOrderID()));
	    $this->setAmount($this->getStringValue($params, 'Amount', $this->getAmount()));
	    $this->setTax($this->getStringValue($params, 'Tax', $this->getTax()));
	    $this->setDocomoDisp1($this->getStringValue($params, 'DocomoDisp1', $this->getDocomoDisp1()));
	    $this->setDocomoDisp2($this->getStringValue($params, 'DocomoDisp2', $this->getDocomoDisp2()));
	    $this->setRetURL($this->getStringValue($params, 'RetURL', $this->getRetURL()));
	    $this->setPaymentTermSec($this->getStringValue($params, 'PaymentTermSec', $this->getPaymentTermSec()));
	}

	/**
	 * 文字列表現
	 * @return string 接続文字列表現
	 */
	function toString() {

	    $str .= 'ShopID=' . $this->encodeStr($this->getShopID());
	    $str .= '&';
	    $str .= 'ShopPass=' . $this->encodeStr($this->getShopPass());
	    $str .= '&';
	    $str .= 'AccessID=' . $this->encodeStr($this->getAccessID());
	    $str .= '&';
	    $str .= 'AccessPass=' . $this->encodeStr($this->getAccessPass());
	    $str .= '&';
	    $str .= 'OrderID=' . $this->encodeStr($this->getOrderID());
	    $str .= '&';
	    $str .= 'Amount=' . $this->encodeStr($this->getAmount());
	    $str .= '&';
	    $str .= 'Tax=' . $this->encodeStr($this->getTax());
	    $str .= '&';
	    $str .= 'DocomoDisp1=' . $this->encodeStr($this->getDocomoDisp1());
	    $str .= '&';
	    $str .= 'DocomoDisp2=' . $this->encodeStr($this->getDocomoDisp2());
	    $str .= '&';
	    $str .= 'RetURL=' . $this->encodeStr($this->getRetURL());
	    $str .= '&';
	    $str .= 'PaymentTermSec=' . $this->encodeStr($this->getPaymentTermSec());
	    return $str;
	}


}
?>
