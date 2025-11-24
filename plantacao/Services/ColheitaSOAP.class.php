<?php
	
	require_once "../Models/Conexao.class.php";
	require_once "../Models/DAO/colheitaDAO.class.php";
	require_once "../Models/Colheita.class.php";
	require_once "../Models/Plantacao.class.php";
	require_once "../Models/Area.class.php";
	require_once '../vendor/autoload.php';
	
    //Header de Login
	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;
	use Firebase\JWT\ExpiredException; 

	$CHAVE_SECRETA = "Segredo";
		
	$server = new soapServer("colheita.wsdl", [
        'cache_wsdl' => WSDL_CACHE_NONE
    ]);
	
	class ColheitaSOAP
	{

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

		//•	Para inserir a colheita por meio de um webservice soap com WSDL;
		public function inserir_colheita_soap($idarea, $idplantacao, $unidade, $data, $quantidade)
        { 
            $ret = $this->VerificarToken();  //Oficialmente o header de login

            if($ret == "ok")
			{
                $area = new Area($idarea);
                $plantacao = new Plantacao($idplantacao);
                $colheita = new Colheita(0, $unidade, $quantidade, $data, $plantacao, $area);

                $colheitaDAO = new colheitaDAO();
                $retorno = $colheitaDAO->inserir_colheita_soap($colheita);
                
                if ($retorno === true) {
                    return json_encode(["sucesso" => true, "mensagem" => "Colheita inserida com sucesso"]);
                } else {
                    return json_encode(["sucesso" => false, "mensagem" => $retorno]);
                }
           }

			if($ret == "expirado")
			{
				return json_encode("Faça login novamente");
			}
			return json_encode("Token Inválido");
        }

        //Resto da lógica para usar o header de login

        public function login()
		{
			global $CHAVE_SECRETA;
			if($this->login !=null)
			{
				if(isset($this->login->email) && isset($this->login->senha))
				{
					if($this->login->email == "usuario@gmail.com" && $this->login->senha == "123")
					{
						//gerar token
						
						$payload = [
							"iss"=>"http://localhost/plantacao/services",
							"aud"=>"http://localhost/colheita",
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
		
	}
	
	$server->setObject(new ColheitaSOAP());
	$server->handle();
	
?>