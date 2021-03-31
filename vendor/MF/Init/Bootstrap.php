<?php

namespace MF\Init;

abstract class Bootstrap {//classe abstrata não pode ser instanciada apenas herdada
	private $routes;

	abstract protected function initRoutes();

	public function __construct() {
		$this->initRoutes();
		$this->run($this->getUrl());
	}

	public function getRoutes() {
		return $this->routes;
	}

	public function setRoutes(array $routes) {
		$this->routes = $routes;
	}

	protected function run($url) {		
		foreach ($this->getRoutes() as $key => $route) {
			if ($url == $route['route']) {
				$class = "App\\Controllers\\".ucfirst($route['controller']); //ucfirst(passa que o primeiro caráctere tem que ser maiúsculo pois o nome da classe IndexController está em maiúsculo)

				$controller = new $class;  //Na essência estamos fazendo isso-> App\Controllers\IndexController

				$action = $route['action'];

				$controller->$action(); //() para executar a ação
			}
		}
	}

	protected function getUrl() {//protegido mas pode ser herdado
		return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
	}
}

?>