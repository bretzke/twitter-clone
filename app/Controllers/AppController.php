<?php

namespace App\Controllers;

//recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

	public function timeline() {

		$this->validaAutenticacao();

		//recuperação dos tweets
		$tweet = Container::getModel('Tweet');

		$tweet->__set('id_usuario', $_SESSION['id']);

		$tweets = $tweet->getAll();

		$this->view->tweets = $tweets;

		$usuario = Container::getModel('Usuario');

		$usuario->__set('id', $_SESSION['id']);

		$this->view->info_usuario = $usuario->getInfoUsuarios();
		$this->view->total_tweets = $usuario->getTotalTweets();
		$this->view->total_seguindo = $usuario->getTotalSeguindo();
		$this->view->total_seguidores = $usuario->getTotalSeguidores();

		$this->render('timeline');
	}

	public function tweet() {

		$this->validaAutenticacao();
			
		$tweet = Container::getModel('Tweet'); //aqui estamos instanciando um objeto

		$tweet->__set('tweet', $_POST['tweet']); //aqui estamos setando o valor desse objeto
		$tweet->__set('id_usuario', $_SESSION['id']); //aqui estamos setando o valor do objeto id do usuário através da super global $_SESSION

		$tweet->salvar();

		header('Location: /timeline');
	}

	public function validaAutenticacao() {

		session_start();

		if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			header('Location: /?login=erro');
		}
	}

	public function quemSeguir() {

		$this->validaAutenticacao();
	
		$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

		$usuarios = array();

		if ($pesquisarPor != '') {
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('nome', $pesquisarPor);
			$usuario->__set('id', $_SESSION['id']);

			$usuarios = $usuario->getAll();
		}

		$usuario = Container::getModel('Usuario');

		//lógica do perfil painel
		$usuario->__set('id', $_SESSION['id']);

		$this->view->info_usuario = $usuario->getInfoUsuarios();
		$this->view->total_tweets = $usuario->getTotalTweets();
		$this->view->total_seguindo = $usuario->getTotalSeguindo();
		$this->view->total_seguidores = $usuario->getTotalSeguidores();

		$this->view->usuarios = $usuarios;

		$this->render('quemSeguir');
	}

	public function acao() {

		$this->validaAutenticacao();

		$acao = isset($_GET['acao']) ? $_GET['acao'] : '';
		$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

		$usuario = Container::getModel('Usuario');

		$usuario->__set('id', $_SESSION['id']);

		if ($acao == 'seguir') {

			$usuario->seguirUsuario($id_usuario_seguindo);

		} else if($acao == 'deixar_de_seguir') {

			$usuario->deixarSeguirUsuario($id_usuario_seguindo);
		}

		header('Location: /quem_seguir');

	}

	public function removerTweet() {
		$this->validaAutenticacao();

		//recuperação dos tweets
		$tweet = Container::getModel('Tweet');

		$id_tweet = isset($_GET['id']) ? $_GET['id'] : '';

		$tweet->__set('id', $id_tweet);

		$tweet->removerTweet();

		header('Location: /timeline');
	}
}

?>