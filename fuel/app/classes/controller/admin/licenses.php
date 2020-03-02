<?php

/**
 * ライセンス管理機能用コントローラ
 */
class Controller_Admin_Licenses extends Controller_Admin
{
    const PER_PAGE = 10;
    
	/** システム管理者専用アクション */
	protected $sysadmin_actions = [
		'all',
		'new',
		'create',
        'edit',
		'update',
		'destroy',
	];

	/**
	 * 全ライセンス一覧画面
	 */
	public function action_all()
	{
        $view = 'admin/licenses/all';
        
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
        $this->license_codes_status = Model_License_Code::STATUS;
        // $usersId = $this->license_codes->users_id;
        // $this->license_temporary_account = Model_License_Code::get_temporary_account($usersId);
        $data['license_codes'] = $this->license_codes;
        $data['license_code_status'] = $this->license_codes_status;
        // $data['license_temporary_account'] = $this->license_temporary_account();

        $this->template->content = View::forge($view, $data);
    }
    
	/**
	 * ライセンス登録画面
	 */
	public function action_new()
	{
		$view = 'admin/licenses/new';
		// $twig      = View_Twig::forge($view);
        // $presenter = Presenter::Forge($view, 'view', null, $twig);
		$this->template->content = View::forge($view);
	}

	/**
	 * ライセンス登録
	 */
	public function action_create()
	{
		if (!Security::check_token()) {
			Log::debug('CSRF token check error.', __METHOD__);
			Session::set_flash('errors', [\Lang::get('common.errors.illegal_operation')]);
			return $this->action_new();
		}
		
		try {
			$params = Input::post();
			$params['shipping_date'] = $this->get_shipping_date();
            Model_License_Code::bulk_register($params);
            return $this->action_all();
		} catch (Orm\ValidationFailed $e) {
			$errors = [];
			foreach ($e->get_fieldset()->validation()->error() as $error) {
				$errors[] = $error->get_message();
			}
			Log::debug(print_r($errors, true), __METHOD__);
			Session::set_flash('errors', $errors);
			return $this->action_new();
        }      
    }

    /**
     * submitの種類によってアクション振り分け
     */
    public function action_submit_select()
    {
        $params = Input::post();
        $submit_type = $params['submit_type'];

        if($submit_type == 'ステータス変更'){
            if ($params['status'] == "none") {
                return $this->action_all();
            }
            $this->action_status_update($params);
        }
        elseif ($submit_type == 'CSV出力') {
            $this->action_get_csv($params);
        }
        else{
            return $this->action_all();
        }
    }
    
    /**
	 * csv出力
	 */
	public function action_get_csv($params)
	{
        $params['shipping_date'] = $this->get_shipping_date();
        $license_ids = $params['license_id'];
        $insert_ids = [];
        foreach ($license_ids as $key => $license_id) {
            $insert_ids[] = $license_id;
        }
        $license_codes = Model_License_Code::get_license_code_by_ids($insert_ids);
        $this->output_csv($license_codes);
	}

	/**
	 * ライセンス編集画面
	 */
	public function action_edit($id)
	{
		$view      = 'admin/licenses/edit';
		$presenter = Presenter::Forge($view, 'view');
		return Response::forge($presenter);
    }
    
    /**
     * 
     */
    public function action_status_update($params)
    {   
        foreach ($params['license_id'] as $key => $licenses_id) {
            $license_data = Model_License_Code::find($licenses_id);
            $license_data->set([
                'status' => $params['status']
            ]);
            $license_data->save();
        }
        return $this->action_all();
    }

	/**
	 * ライセンス更新
	 */
	public function action_update($params)
	{
		if (!Security::check_token()) {
			Log::debug('CSRF token check error.', __METHOD__);
			Session::set_flash('errors', [\Lang::get('common.errors.illegal_operation')]);
			return $this->action_edit($id);
		}

		// 出荷日が指定されていれば取得
		$shipping_date = call_user_func(function() {
			if (Input::post('shipping_year') && Input::post('shipping_month') && Input::post('shipping_day')) {
				return Input::post('shipping_year') . '-' .
					str_pad(Input::post('shipping_month'), 2, "0", STR_PAD_LEFT) . '-' .
					str_pad(Input::post('shipping_day'), 2, "0", STR_PAD_LEFT);
			} else {
				return null;
			}
		});

		try {
			$sensor = Model_Sensor::find($id);
			// ライセンスが取得できなかった場合は 404
			if (!isset($sensor)) {
				throw new HttpNotFoundException;
			}
			$sensor->set([
				'facility_id'    => Input::post('facility_id'),
				'sensor_type_id' => Input::post('sensor_type_id'),
				'shipping_date'  => $shipping_date,
			]);
			$sensor->save();

			Session::set_flash('success', 'ライセンス機器ID「' . $sensor->name .  '」を更新しました。');
			// 更新後は元のページに戻すためページ番号を維持
			$page = Input::post('page');
			return Response::redirect("admin/licenses/all/{$page}");
		} catch (Orm\ValidationFailed $e) {
			$errors = [];
			foreach ($e->get_fieldset()->validation()->error() as $error) {
				$errors[] = $error->get_message();
			}
			Log::debug(print_r($errors, true), __METHOD__);
			Session::set_flash('errors', $errors);
			return $this->action_edit($id);
		}
	}

	/**
	 * ライセンス削除
	 */
	public function action_destroy($id)
	{
		if (!Security::check_token()) {
			Log::debug('CSRF token check error.', __METHOD__);
			Session::set_flash('errors', [\Lang::get('common.errors.illegal_operation')]);
			return $this->action_index();
        }
        
        $sensor = Model_Sensor::find($id);
		$sensor->delete();

		Session::set_flash('success', 'ライセンス機器ID「' . $sensor->name .  '」を削除しました。');

		// 削除後は元のページに戻すためページ番号を維持
		return Response::redirect(Input::referrer());

		Session::set_flash('success', 'ライセンス機器ID「' . $sensor->name .  '」を削除しました。');

		// 削除後は元のページに戻すためページ番号を維持
		return Response::redirect(Input::referrer());
	}

	/**
	 * 発行したライセンスコードの一覧をCSVを出力する
	 * @param $license_codes
	 */
	private function output_csv($license_codes)
	{
		$data = [];
		foreach ($license_codes as $license_code){
			$data[] = [
				$license_code['id'],
				$license_code['code'],
				//TODO 仮アカウント
				$license_code['name'].'('.$license_code['sensor_type_name'].')',
				$license_code['status'],
				$license_code['shipping_date']
			];
		}

		$file_name = date('YmdHi').'_license_code.csv';
		$this->template = null;
		$this->response = new Response();
		$this->response->set_header('Content-Type', 'application/csv');
		$this->response->set_header('Content-Disposition', 'attachment; filename="'.$file_name.'"');
		$this->response->send(true);
		echo Format::forge()->to_csv($data);
    }

    /**
	 * 出荷日を返す
	 * @return null|string
	 */
	protected function get_shipping_date()
	{
		if (Input::post('shipping_year') && Input::post('shipping_month') && Input::post('shipping_day')) {
			return Input::post('shipping_year') . '-' .
				str_pad(Input::post('shipping_month'), 2, "0", STR_PAD_LEFT) . '-' .
				str_pad(Input::post('shipping_day'), 2, "0", STR_PAD_LEFT);
		} else {
			return null;
		}
	}
}
