<?php 
	if(!isset($_SESSION))
	{
		session_start();
	}

    class colheitaController{

		public function inserirColheitaSoap()
		{
			if (!isset($_SESSION["token"])) {
				die("Você precisa fazer login primeiro!");
			}

			$client = new SoapClient("http://localhost/plantacao/services/ColheitaSOAP.class.php?wsdl");

			$aut_param = new stdClass();
			$aut_param->token = $_SESSION["token"];
			
			$header_parm = new soapVar($aut_param, SOAP_ENC_OBJECT);

			$header = new soapHeader("http://localhost/plantacao/services/ColheitaSOAP.class.php","token",$header_parm,false);

			$client->__setSoapHeaders(array($header));

			// Buscar todas as plantações via REST
			$jsonPlantacoes = file_get_contents("http://localhost/plantacao/services/plantacaoRest.class.php?oper=Buscar_Plantacao");
			$retornoPlantacoes = json_decode($jsonPlantacoes);
			
			// Buscar todas as áreas via REST (o endpoint que acabamos de criar)
			$jsonAreas = file_get_contents("http://localhost/plantacao/services/plantacaoRest.class.php?oper=Buscar_Areas");
			$retornoAreas = json_decode($jsonAreas);

			// Verificar se os dados vieram antes de carregar a view
			if (is_array($retornoPlantacoes) && is_array($retornoAreas)) {
				require_once "Views/colheita_forms_soap.php";
			} else {
				echo "Erro ao buscar dados de áreas ou plantações.";
			}
		}

		public function salvarColheitaSoap()
		{
			$client = new SoapClient("http://localhost/plantacao/services/ColheitaSOAP.class.php?wsdl");		

			$aut_param = new stdClass();
			$aut_param->token = $_SESSION["token"];
			$header_parm = new soapVar($aut_param, SOAP_ENC_OBJECT);
			$header = new soapHeader("http://localhost/plantacao/services/ColheitaSOAP.class.php","token",$header_parm,false);

			$client->__setSoapHeaders(array($header));

			try {   
				$idarea        = (int) $_POST['idarea'];
				$idplantacao   = (int) $_POST['idplantacao'];
				$unidade       = $_POST['unidade'];
				$data_colheita = $_POST['data_colheita'];
				$quantidade    = $_POST['quantidade']; 
				$retorno = $client->inserir_colheita_soap(
					$idarea, 
					$idplantacao, 
					$unidade, 
					$data_colheita, 
					$quantidade
				);
				echo "Colheita inserida via SOAP com sucesso!";
				
			} catch (SoapFault $e) {
				echo "Erro ao chamar o serviço SOAP: " . $e->getMessage();
			}
		}
    }
?>