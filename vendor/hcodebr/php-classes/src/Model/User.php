<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

Class User extends Model{

	const SESSION = "User";

	public static function login($email, $senha){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE email_usuario = :EMAIL", array(
			":EMAIL"=>$email
		));

		if(count($results) === 0){

			throw new \Exception("Usário inexistente ou senha inválida");		
		}

		$data = $results[0];

		if(password_verify($senha, $data["senha_usuario"])){

			$user = new User();

			$user->setData($data);

			$_SESSION[User::SESSION] = $user->getValues();

			return $user;
		
		} else {

			throw new \Exception("Usário inexistente ou senha inválida");
		}

	}

	public static function verifyLogin($inadmin = true){

		if(
			!isset($_SESSION[User::SESSION])
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]["id_usuario"] > 0
			||
			(bool)$_SESSION[User::SESSION]["tb_tipo_usuarios_id_tipo"] !== $inadmin

		) {
			header("Location: /login");
			exit;
		}
	}

	public static function verifyADM(){

		if($_SESSION[User::SESSION]["id_usuario"] != 1){

			echo "Permissão negada!";
			exit;
		}

	}

	public static function verifyUserType(){

		if((int)$_SESSION[User::SESSION]["id_usuario"] == 1){

			header('Location: /admin/ver-contagens');
			exit;

		} else {

			header('Location: /ver-contagens');
			exit;
		}
	}

	public static function logout(){

		$_SESSION[User::SESSION] = NULL;
	}

	public static function listAll(){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_usuarios ORDER BY id_usuario");

	}

	public function save(){

		$sql = new Sql();

		$sql->query("INSERT INTO  tb_usuarios VALUES(null, :DESPERSON, :DESEMAIL , :DESPASSWORD, :INADMIN)", array(
			":DESPERSON"=>$this->getnome_usuario(),
			":DESEMAIL"=>$this->getemail_usuario(),
			":DESPASSWORD"=>$this->getsenha_usuario(),
			":INADMIN"=>$this->getinadmin()
		));
	}

	public function get($id_usuario){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE id_usuario = :IDUSUARIO", array(
			':IDUSUARIO'=>$id_usuario
		));

		$this->setData($results[0]);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_update_user(:IDUSUARIO, :DESPERSON, :DESEMAIL , :DESPASSWORD, :INADMIN)", array(
			":IDUSUARIO"=>$this->getid_usuario(),
			":DESPERSON"=>$this->getnome_usuario(),
			":DESEMAIL"=>$this->getemail_usuario(),
			":DESPASSWORD"=>$this->getsenha_usuario(),
			":INADMIN"=>$this->getinadmin()
		));

		$this->setData($results[0]);
	}

	public function delete(){

		$sql = new Sql();

		$sql->query("DELETE FROM tb_usuarios WHERE id_usuario = :IDUSUARIO", array(
			":IDUSUARIO"=>$this->getid_usuario()
		));
	}

	public function tipoUsuario(){

		$sql = new Sql();

		return $results = $sql->select("SELECT * FROM 	tb_tipo_usuarios");
	}
}
?>