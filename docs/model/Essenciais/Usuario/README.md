###Usuário

* O Usuario.php é a utilização de codigos para fazer a interface de uma parte do site, onde voce vai logar ou fazer o cadastro em determinada área.

```

namespace Application\Model;

class Usuario{
	private $id;
	private $email;
	private $cpf;
	private $senha;
	private $userArray;
	
	//getters
	public function getId(){
	return $this->id;
	}
	public function getEmail(){
	return $this->email;
	}
	public function getCpf(){
	return $this->cpf;
	}
	public function getSenha(){
	return $this->senha;
	}

	//setters

	public function setId($id){
	$this->id = $id; 
	}
	public function setEmail($email){
	$this->email = $email; 
	}
	public function setCpf($cpf){
	$this->cpf = $cpf;
	}
	public function setSenha($senha){
	$this->senha = $senha;
	}
	
	public function toArray(){
	return $this->userArray = array(
	"id" => $this->getId(),
	"email" => $this->getEmail(),
	"cpf" => $this->getCpf(),
	"senha" => $this->getSenha(),
	);
	}
	
}

```