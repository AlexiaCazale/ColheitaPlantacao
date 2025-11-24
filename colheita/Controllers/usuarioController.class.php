<?php
    class usuarioController{

        //Header de Login feito com SOAP -> o usuário só terá acesso a tal página se estiver logado (o login já vem inserido no aut_param)
        
        public function login()
		{
			if(!isset($_SESSION))
			{
				session_start();
			}
			
			$client = new SoapClient("http://localhost/plantacao/services/ColheitaSOAP.class.php?wsdl");
			
			$aut_param = new stdClass();
			$aut_param->email = "usuario@gmail.com";
			$aut_param->senha = "123";

			$header_parm = new soapVar($aut_param, SOAP_ENC_OBJECT);

			$header = new soapHeader("http://localhost/plantacao/services/ColheitaSOAP.class.php","security",$header_parm,false);

			$client->__setSoapHeaders(array($header));
				
			$retorno = $client->login();
			
			$_SESSION["token"] = json_decode($retorno);
			var_dump($_SESSION["token"]);

			echo "Login efetuado com sucesso. <br>";
			echo "<a href='index.php'>Voltar ao Início</a>";
		}

		public function logout()
		{
			if(!isset($_SESSION))
			{
				session_start();
			}
			// Remove todas as variáveis de sessão
			session_unset();
			// Destrói a sessão
			session_destroy();
			
			echo "Logout efetuado com sucesso. <br>";
			echo "<a href='index.php'>Voltar ao Início</a>";
		}
    }

?>