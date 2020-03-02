<?php

/**
 * Class Presenter_Backend_Licenses_All
 *
 * @property string $query
 */
class Presenter_Admin_Licenses_All extends Presenter
{
	// 1 ページあたりの表示数
	const PER_PAGE = 10;

	public function view()
	{
		// 現在のページ番号を URL から取り出して保存
		$this->page = Uri::segment(4);
		$total = Model_License_Code::count();
		
		Log::debug("license_code total count: [{$total}]", __METHOD__);

		$config = [
			'pagination_url' => "admin/licenses/all",
			'uri_segment'    => 4,
			'per_page'       => self::PER_PAGE,
			'total_items'    => $total
		];

		$pagination = Pagination::forge('licenses_all_pagination', $config);
		$this->license_codes = Model_License_Code::find_all_pagination($pagination);
		
		# Twig からはメソッドは呼べないのでページネーションリンクは変数に保持しておく
		$this->set('licenses_all_pager_link', $pagination->render(), false);
	}
}
