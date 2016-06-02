<?php
class Controller_Alert extends Controller
{
	public function action_index($type)
        {
		$template = Config::get("template");
                $data = $template[$type];
		return Response::forge(View::forge('alert', $data));
    	}
}
