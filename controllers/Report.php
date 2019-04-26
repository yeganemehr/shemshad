<?php
namespace packages\shemshad\controllers;

use packages\base\{Controller, View, Response};
use themes\shemshad\views;

class Report extends Controller {
	public function index() {
		$response = new Response();
		$view = View::byName(views\Report::class);
		$response->setView($view);

		return $response;
	}
}
