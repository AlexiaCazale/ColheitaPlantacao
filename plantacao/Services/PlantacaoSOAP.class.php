<?php
	
	require_once "../Models/Conexao.class.php";
	require_once "../Models/platacaoDAO.class.php";
	require_once "../Models/Colheita.class.php";
	require_once "../Models/Plantacao.class.php";
	require_once "../Models/Area.class.php";
	require_once '../vendor/autoload.php';
	
	
	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;
	use Firebase\JWT\ExpiredException; 

	$CHAVE_SECRETA = "Segredo";
	
	$server = new soapServer("plantacao.wsdl");
	
	class plantacaoSOAP
	{

		//•	Para inserir a colheita por meio de um webservice soap com WSDL;
		private $login = null;
		private $token = null;
		function security($header)
		{
			$this->login = $header;
		}
		function token($header) 
		{
			$this->token = $header->token;
		}
		public function inserir_colheita_soap(Colheita $colheita)
		{
			$plantacaoDAO = new plantacaoDAO();
			$retorno = $plantacaoDAO->inserir_colheita_soap($colheita);
			return json_encode($retorno);
		}
		
		public function login()
		{
			global $CHAVE_SECRETA;
			if($this->login !=null)
			{
				if(isset($this->login->email) && isset($this->login->senha))
				{
					if($this->login->email == "vania@gmail.com" && $this->login->senha == "123")
					{
						//gerar token
						
						$payload = [
							"iss"=>"http://localhost/plantacao/services",
							"aud"=>"http://localhost/livraria",
							"iat"=>time(),
							"exp"=>time() + 3600,
							"user_id"=>"123"
						];
						$jwt = JWT::encode($payload, $CHAVE_SECRETA, "HS256");
						return json_encode($jwt);
					}
				}
			}
			throw new \SoapFault("Client", "Credenciais de autenticação ausentes ou inválidas.");
		}
		private function VerificarToken()
		{
			global $CHAVE_SECRETA;
			if(empty($this->token)) {
				return "invalido";
			}
			
			try
			{
				$decode = JWT::decode($this->token, new key($CHAVE_SECRETA, "HS256"));
				
				return "ok";
			}
			catch(\Firebase\JWT\ExpiredException $e)
			{
				return "expirado"; 
			}
			catch(\Exception $e)
			{
				
				return "invalido";
			}
		}
	}//fim da classe
	
	
	$server->setObject(new plantacaoSOAP());
	$server->handle();
	
?>