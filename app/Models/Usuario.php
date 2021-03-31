<?php

namespace App\Models; //namespace é constituido pelo nome dos diretórios

use MF\Model\Model;

class Usuario extends Model {

	private $id;
	private $nome;
	private $email;
	private $senha;

	public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
	}

	//nosso model vai ter que:

	//salvar
	public function salvar() {
		$query = "insert into usuarios(nome, email, senha)values(:nome, :email, :senha)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha')); //md5() - para criptografar a senha criando um hash de 32 caracteres
		$stmt->execute();

		return $this;
	}

	//validar se um cadastro pode ser feito
	public function validarCadastro() {
		$valido = true;

		if (strlen($this->__get('nome')) < 3) {
			$valido = false;
		}

		if (strlen($this->__get('email')) < 3) {
			$valido = false;
		}

		if (strlen($this->__get('senha')) < 7) {
			$valido = false;
		}

		return $valido;
	}

	//recuperar um usuário por e-mail
	public function getUsuarioPorEmail() {
		$query = "select nome, email from usuarios where email = :email";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function autenticar() {
		$query = "
		select
			id, nome, email
		from
			usuarios
		where
			email = :email
		and
			senha = :senha
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));

		$stmt->execute();

		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

		if ($usuario['id'] != '' && $usuario['nome'] != '') {
			$this->__set('id', $usuario['id']);
			$this->__set('nome', $usuario['nome']);
		}

		return $this;
	}

	public function getAll() {
		$query = "
		select
			u.id,
			u.nome,
			u.email,
			(
			select
				count(*)
			from
				usuarios_seguidores as us
			where
				us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
				) as seguindo_sn
		from
			usuarios as u
		where
			u.nome like :nome
		and
			u.id != :id_usuario
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', '%'.$this->__get('nome').'%'); //usamos o '%' são os coringas e tem a função de dizer que pode ter algo a mais antes e depois do nome para não ficar uma pesquisa com os nomes iguais e sim algo perto
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function seguirUsuario($id_usuario_seguindo) {
		$query = "
		insert into usuarios_seguidores(id_usuario, id_usuario_seguindo)
		values(:id_usuario, :id_usuario_seguindo)
		";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);

		$stmt->execute();

		return true;
	}

	public function deixarSeguirUsuario($id_usuario_seguindo) {
		$query = "delete from usuarios_seguidores where id_usuario = :id_usuario and
		id_usuario_seguindo = :id_usuario_seguindo";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);

		$stmt->execute();

		return true;
	}

	//método das informações do usuário
	public function getInfoUsuarios() {
		$query = 'select nome from usuarios where id = :id_usuario';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	//total dos tweets
	public function getTotalTweets() {
		$query = 'select count(*) as total_tweet from tweets where id_usuario = :id_usuario';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	//total de usuários que estamos seguindo
	public function getTotalSeguindo() {
		$query = 'select count(*) as total_seguindo from usuarios_seguidores where id_usuario = :id_usuario';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	//total de seguidores
	public function getTotalSeguidores() {
		$query = 'select count(*) as total_seguidores from usuarios_seguidores where id_usuario_seguindo = :id_usuario';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
}

?>