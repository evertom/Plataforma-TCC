<?php
require_once('Conexao.class.php');
require_once('Auxiliar.class.php');

 class Insere extends Conexao{
	private $data = array();

	public function __construct(){
		$this->erro = '';
	}
	
	public function __set($name, $value){
        $this->data[$name] = $value;
    }

    public function __get($name){
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
	
    // aqui comeчa a criar os metodos (function)
	
	public function AddCat(){
		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
				
		//preparaчуo para a query com os metodos pdo
		$stmt = $this->pdo->prepare('INSERT INTO categoria(descri_cat) VALUES (:pdescri_cat)');
		$stmt->bindValue(':pdescri_cat', $this->tituloPost, PDO::PARAM_STR);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function AddComentario(){
		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
				
		//preparaчуo para a query com os metodos pdo
		$stmt = $this->pdo->prepare('INSERT INTO comentario(nome_coment,email_coment,coment,data_coment,aproved,thumb,id_post) VALUES (:pnome_coment,:pemail_coment,:pcoment,current_date(),1,:pthumb,:pid_post)');
		$stmt->bindValue(':pnome_coment', $this->nome, PDO::PARAM_STR);
		$stmt->bindValue(':pemail_coment', $this->email, PDO::PARAM_STR);
		$stmt->bindValue(':pcoment', $this->comentario, PDO::PARAM_STR);
		$stmt->bindValue(':pthumb', $this->thumb, PDO::PARAM_STR);
		$stmt->bindValue(':pid_post', $this->idPost, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function AtualizaCat(){
			 		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
		//preparaчуo para a query com os metodos pdo
		$stmt = $this->pdo->prepare('UPDATE categoria SET descri_cat = :pdescri_cat WHERE id_categoria = :pid_categoria');
		$stmt->bindValue(':pdescri_cat', $this->tituloPost, PDO::PARAM_STR);
		$stmt->bindValue(':pid_categoria', $this->idPost, PDO::PARAM_STR);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function AtualizaQntPost(){
			 		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
		//preparaчуo para a query com os metodos pdo
		$stmt = $this->pdo->prepare('UPDATE post SET qntAcesso = :pqntAcesso WHERE id_post = :pid_post');
		$stmt->bindValue(':pqntAcesso', $this->qntAcesso, PDO::PARAM_INT);
		$stmt->bindValue(':pid_post', $this->id_post, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function AtualizaThumb(){
			 		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
		//preparaчуo para a query com os metodos pdo
		$stmt = $this->pdo->prepare('UPDATE post SET thumb = :pthumb WHERE id_post = :pid_post');
		$stmt->bindValue(':pthumb', $this->thumb, PDO::PARAM_STR);
		$stmt->bindValue(':pid_post', $this->idPost, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function AtualizaPerfil(){
			 		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
		//preparaчуo para a query com os metodos pdo
		$stmt = $this->pdo->prepare('UPDATE perfil SET nome_perfil = :pnome_perfil, idade_perfil = :pidade_perfil, cidade_perfil = :pcidade_perfil, cor_perfil = :pcor_perfil, signo_perfil = :psigno_perfil, altura_perfil = :paltura_perfil, email = :pemail, sobre_perfil = :psobre_perfil  WHERE id_perfil = :pid_perfil');
		
		$stmt->bindValue(':pnome_perfil', $this->nome, PDO::PARAM_STR);
		$stmt->bindValue(':pidade_perfil', $this->idade, PDO::PARAM_INT);
		$stmt->bindValue(':pcidade_perfil', $this->cidade, PDO::PARAM_STR);
		$stmt->bindValue(':pcor_perfil', $this->cor, PDO::PARAM_STR);
		$stmt->bindValue(':psigno_perfil', $this->signo, PDO::PARAM_STR);
		$stmt->bindValue(':paltura_perfil', $this->altura, PDO::PARAM_STR);
		$stmt->bindValue(':pemail', $this->email, PDO::PARAM_STR);
		$stmt->bindValue(':psobre_perfil', $this->mensagem, PDO::PARAM_STR);
		$stmt->bindValue(':pid_perfil', $this->id_perfil, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function AprovaComent(){
			 		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
		//preparaчуo para a query com os metodos pdo
		$stmt = $this->pdo->prepare('UPDATE comentario SET nome_coment = :pnome_coment, email_coment = :pemail_coment, coment = :pcoment, aproved = :paproved WHERE id_coment = :pid_coment');
		$stmt->bindValue(':pnome_coment', $this->nome, PDO::PARAM_STR);
		$stmt->bindValue(':pemail_coment', $this->email, PDO::PARAM_STR);
		$stmt->bindValue(':pcoment', $this->mensagem, PDO::PARAM_STR);
		$stmt->bindValue(':paproved', $this->aprovei, PDO::PARAM_INT);
		$stmt->bindValue(':pid_coment', $this->id_coment, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function deleteCat(){
		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
		
		$stmt = $this->pdo->prepare( "DELETE FROM categoria WHERE id_categoria = :pid_categoria" );
		$stmt->bindValue(':pid_categoria', $this->idcat, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function AddPost(){
		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
		
		$stmt = $this->pdo->prepare('INSERT INTO post(titulo,intro,msg,autor,data,data2,thumb,id_categoria,id_login) VALUES (:ptitulo,:pintro,:pmsg,:pautor,current_date(),now(),:pthumb,:pid_categoria,:pid_login)');
		
		$stmt->bindValue(':ptitulo', $this->tituloPost, PDO::PARAM_STR);
		$stmt->bindValue(':pintro', $this->introducao, PDO::PARAM_STR);
		$stmt->bindValue(':pmsg', $this->mensagem, PDO::PARAM_STR);
		$stmt->bindValue(':pautor', $this->nome_user, PDO::PARAM_STR);
		$stmt->bindValue(':pthumb', $this->thumb, PDO::PARAM_STR);
		$stmt->bindValue(':pid_categoria', $this->categoria, PDO::PARAM_INT);
		$stmt->bindValue(':pid_login', $this->id_login, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function UpdatePost(){
		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }
		
		$stmt = $this->pdo->prepare('UPDATE post SET titulo = :ptitulo, intro = :pintro, msg = :pmsg, id_categoria = :pid_categoria WHERE id_post = :pid_post');
		
		$stmt->bindValue(':ptitulo', $this->tituloPost, PDO::PARAM_STR);
		$stmt->bindValue(':pintro', $this->introducao, PDO::PARAM_STR);
		$stmt->bindValue(':pmsg', $this->mensagem, PDO::PARAM_STR);
		$stmt->bindValue(':pid_categoria', $this->categoria, PDO::PARAM_INT);
		$stmt->bindValue(':pid_post', $this->idPost, PDO::PARAM_INT);
		$stmt->execute();
		
		parent::desconectar();
		return true;
	}
	
	public function deletePost(){
		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }

		$stmt = $this->pdo->prepare( "DELETE FROM comentario WHERE id_post = :pid_post" );
		$stmt->bindValue(':pid_post', $this->idpost, PDO::PARAM_INT);
		
		if($stmt->execute()){
		
			$stmt2 = $this->pdo->prepare( "DELETE FROM post WHERE id_post = :pid_post" );
			$stmt2->bindValue(':pid_post', $this->idpost, PDO::PARAM_INT);
			
			if($stmt2->execute()){
				parent::desconectar();
				return true;
			}else{
				parent::desconectar();
				return false;
			}
		}else{
			parent::desconectar();
			return false;
		}
	}
	
	public function deleteComent(){
		
		if(parent::getPDO() == null){
              //caso nуo tenha conecta-se com o banco de dados
               parent::conectar();
        }

		$stmt = $this->pdo->prepare( "DELETE FROM comentario WHERE id_coment = :pid_coment" );
		$stmt->bindValue(':pid_coment', $this->idComent, PDO::PARAM_INT);
		
		if($stmt->execute()){
			parent::desconectar();
			return true;
		}else{
			parent::desconectar();
			return false;
		}
		
	}
	
 }/*fechamento da chave principal da classe*/
?>