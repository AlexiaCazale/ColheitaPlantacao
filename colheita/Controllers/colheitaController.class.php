<?php 
    class colheitaController{

       // Este método apenas busca dados (GET).
        public function tabelaPlantacaoRest()
        {
            // O serviço REST (plantacaoRest.class.php) precisa 
            // estar com o roteamento GET descomentado 
            $retorno = file_get_contents("http://localhost/plantacao/services/plantacaoRest.class.php?oper=Buscar_Plantacao");
            $retorno = json_decode($retorno);
            if(is_array($retorno))
            {
                require_once "Views/listar_colheitas.php";
            }
            else
            {
                echo $retorno;
            }
        }
      	public function inserirAreaRest()
        {
            require_once "Views/area_forms_rest.php";
        }

       // ... em colheitaController.class.php

		public function inserirColheitaSoap()
		{
			// 1. Buscar todas as plantações via REST
			$jsonPlantacoes = file_get_contents("http://localhost/plantacao/services/plantacaoRest.class.php?oper=Buscar_Plantacao");
			$retornoPlantacoes = json_decode($jsonPlantacoes);
			
			// 2. Buscar todas as áreas via REST (o endpoint que acabamos de criar)
			$jsonAreas = file_get_contents("http://localhost/plantacao/services/plantacaoRest.class.php?oper=Buscar_Areas");
			$retornoAreas = json_decode($jsonAreas);

			// 3. Verificar se os dados vieram antes de carregar a view
			if (is_array($retornoPlantacoes) && is_array($retornoAreas)) {
				require_once "Views/colheita_forms_soap.php";
			} else {
				echo "Erro ao buscar dados de áreas ou plantações.";
			}
		}

    	// ... em colheitaController.class.php

		public function salvarColheitaSoap()
		{
			try {
				$wsdl_url = "http://localhost/plantacao/Services/plantacao.wsdl"; 
				$client = new SoapClient($wsdl_url, [
                    'cache_wsdl' => WSDL_CACHE_NONE
                ]);
                $colheita = new stdClass();
                $colheita->idarea        = (int) $_POST['idarea'];
                $colheita->idplantacao   = (int) $_POST['idplantacao'];
                $colheita->unidade       = $_POST['unidade'];
                $colheita->quantidade    = (float) $_POST['quantidade'];
                $colheita->data_colheita = $_POST['data_colheita'];

				// $dadosColheita = [
                //     'idarea' => $_POST['idarea'],
				// 	'idplantacao' => $_POST['idplantacao'], 
				// 	'data_colheita' => $_POST['data_colheita'],
				// 	'quantidade' => $_POST['quantidade'],
				// 	'unidade' => $_POST['unidade']
				// ];

                $colheitaObj = (object)[
                    "idarea"        => (int)$_POST['idarea'],
                    "idplantacao"   => (int)$_POST['idplantacao'],
                    "unidade"       => $_POST['unidade'],
                    "quantidade"    => (float)$_POST['quantidade'],
                    "data_colheita" => $_POST['data_colheita']
                ];
				
				$retorno = $client->inserir_colheita_soap($colheita); 
				

                // $retorno = $client->inserir_colheita_soap($dadosColheita); 

				echo "Colheita inserida via SOAP com sucesso!";
				var_dump($retorno);

			} catch (SoapFault $e) {
				echo "Erro ao chamar o serviço SOAP: " . $e->getMessage();
			}
		}

        public function salvarAreaRest()
        {
            // 1. A URL do serviço REST (plantacaoRest.class.php)
            $url = "http://localhost/plantacao/services/plantacaoRest.class.php";

            // 2. Os dados a enviar (vindos do formulário $_POST)
            $dadosPost = [
                'oper' => 'inserir_area_rest', // O gatilho para o POST (precisa ser tratado no Rest)
                'medida' => $_POST['medida'],
                'unidade' => $_POST['unidade'],
                'latitude' => $_POST['latitude'],
                'longitude' => $_POST['longitude']
            ];

            // 3. Configurar o cURL para POST
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a resposta como string
            curl_setopt($ch, CURLOPT_POST, true); // Define o método como POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dadosPost)); // Envia os dados

            // 4. Executar e obter a resposta
            $response = curl_exec($ch);
            curl_close($ch);

            // 5. Mostrar o resultado
            echo "Resposta do serviço REST (POST): ";
            var_dump($response);
        }
    }

?>