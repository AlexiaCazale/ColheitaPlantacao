<?php
	
	require_once "../Models/Conexao.class.php";
	require_once "../Models/plantacaoDAO.class.php";
	require_once "../Models/Colheita.class.php";
	require_once "../Models/Plantacao.class.php";
	require_once "../Models/Area.class.php";
	require_once '../vendor/autoload.php';
	
	use Firebase\JWT\JWT;
	use Firebase\JWT\Key;
	use Firebase\JWT\ExpiredException; 
	
	$server = new soapServer("plantacao.wsdl", [
        'cache_wsdl' => WSDL_CACHE_NONE
    ]);
	
	class plantacaoSOAP
	{

		//•	Para inserir a colheita por meio de um webservice soap com WSDL;
		public function inserir_colheita_soap(array $colheita)
        {
            try {
                // 2. LÓGICA ATUALIZADA: 
                //    Trocamos '$dadosColheita' por '$colheita'
                
                // Criamos um objeto Area apenas com o ID que recebemos
                $area = new Area((int)$colheita['idarea']);

                // Criamos um objeto Plantacao apenas com o ID que recebemos
                $plantacao = new Plantacao((int)$colheita['idplantacao']);

                // Criamos o objeto Colheita completo
                $colheitaObj = new Colheita(
                    0, // idcolheita (automático no banco)
                    $area,
                    $plantacao,
                    $colheita['data_colheita'],
                    (float)$colheita['quantidade'],
                    $colheita['unidade']
                );

                // 3. AGORA CHAMAMOS O DAO com o objeto $colheitaObj completo
                $plantacaoDAO = new plantacaoDAO();
                $retorno = $plantacaoDAO->inserir_colheita_soap($colheitaObj);
                
                if ($retorno === true) {
                    return json_encode(["sucesso" => true, "mensagem" => "Colheita inserida com sucesso"]);
                } else {
                    return json_encode(["sucesso" => false, "mensagem" => $retorno]);
                }

            } catch (Exception $e) {
                return json_encode(["sucesso" => false, "mensagem" => "Erro no servidor SOAP: " . $e->getMessage()]);
            }
        }
		
	}//fim da classe
	
	
	$server->setObject(new plantacaoSOAP());
	$server->handle();
	
?>