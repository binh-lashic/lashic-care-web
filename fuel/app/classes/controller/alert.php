<?php
class Controller_Alert extends Controller
{
	public function action_info($type)
        {
		$template = Config::get("template");
                $alert = $template['alert'];
                $data = $alert[$type];
		return Response::forge(View::forge('alert', $data));
    	}
}
