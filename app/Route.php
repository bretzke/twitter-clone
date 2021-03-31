<?php

namespace App;

use MF\Init\Bootstrap; //estamos importando o namespace de vendor/Init/Bootstrap.php

class Route extends Bootstrap {

	protected function initRoutes() {
		$routes['home'] = array(
			'route' => '/', //aqui estamos passando a raiz do site
			'controller' => 'indexController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'index' //aqui estamos passando qual é a ação
		);

		$routes['inscreverse'] = array(
			'route' => '/inscreverse', //aqui estamos passando a raiz do site
			'controller' => 'indexController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'inscreverse' //aqui estamos passando qual é a ação
		);

		$routes['registrar'] = array(
			'route' => '/registrar', //aqui estamos passando a raiz do site
			'controller' => 'indexController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'registrar' //aqui estamos passando qual é a ação
		);

		$routes['autenticar'] = array(
			'route' => '/autenticar', //aqui estamos passando a raiz do site
			'controller' => 'AuthController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'autenticar' //aqui estamos passando qual é a ação
		);

		$routes['timeline'] = array(
			'route' => '/timeline', //aqui estamos passando a raiz do site
			'controller' => 'AppController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'timeline' //aqui estamos passando qual é a ação
		);

		$routes['sair'] = array(
			'route' => '/sair', //aqui estamos passando a raiz do site
			'controller' => 'AuthController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'sair' //aqui estamos passando qual é a ação
		);

		$routes['tweet'] = array(
			'route' => '/tweet', //aqui estamos passando a raiz do site
			'controller' => 'AppController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'tweet' //aqui estamos passando qual é a ação
		);

		$routes['quem_seguir'] = array(
			'route' => '/quem_seguir', //aqui estamos passando a raiz do site
			'controller' => 'AppController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'quemSeguir' //aqui estamos passando qual é a ação
		);

		$routes['acao'] = array(
			'route' => '/acao', //aqui estamos passando a raiz do site
			'controller' => 'AppController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'acao' //aqui estamos passando qual é a ação
		);

		$routes['remover_tweet'] = array(
			'route' => '/remover_tweet', //aqui estamos passando a raiz do site
			'controller' => 'AppController', //aqui estamos passando qual é o arquivo controlador
			'action' => 'removerTweet' //aqui estamos passando qual é a ação
		);


		$this->setRoutes($routes);
	}
}

?>