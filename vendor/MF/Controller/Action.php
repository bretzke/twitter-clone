<?php

namespace MF\Controller;

	abstract class Action {
		protected $view;

		public function __construct() {
			$this->view = new \stdClass(); //stdClass() - classe nativa do php
		}

		protected function render($view, $layout = 'layout') {
			$this->view->page = $view;
			$pagina = "../App/Views/".$layout.".phtml";
			
			if(file_exists($pagina)) {
			require_once $pagina;
			} else {
				$this->content();
			}
		}

		public function content() {
			$classAtual = get_class($this);

			$classAtual = str_replace('App\\Controllers\\', '', $classAtual);

			$classAtual = strtolower(str_replace('Controller', '', $classAtual));

			require_once "../App/Views/".$classAtual."/".$this->view->page.".phtml";
		}
	}

?>