<?php
	require_once "../Models/Conexao.class.php";
	require_once "../Models/plantacaoDAO.class.php";
	require_once "../Models/Colheita.class.php";
	require_once "../Models/Plantacao.class.php";
	require_once "../Models/Area.class.php";
	class PlantacaoRest
	{

		// •	Para buscar todas as plantações no Banco de Dados por meio de um webservice Rest (get);
		// •	Para inserir a Área da plantação no Banco de dados por meio de um serviço Rest(Post)

		public function Buscar_Plantacao()
		{
			$plantacaoDAO = new plantacaoDAO();
			$retorno = $plantacaoDAO->buscar_todas_plantacoes();
			return json_encode($retorno);
		}
		public function inserir_area_rest(Area $area)	
		{
			$plantacaoDAO = new plantacaoDAO();
			$retorno = $plantacaoDAO->inserir_area($area);
			return json_encode($retorno);
		}

		public function Buscar_Areas()
		{
			$plantacaoDAO = new plantacaoDAO();
			$retorno = $plantacaoDAO->buscar_todas_areas();
			return json_encode($retorno);
		}
	}

	// Roteador GET (para Buscar_Plantacao)
   // Roteador GET (para Buscar_Plantacao E Buscar_Areas)
	if (isset($_GET['oper'])) 
	{
		$operacao = $_GET['oper'];
		$obj = new PlantacaoRest();

		if (method_exists($obj, $operacao)) 
		{
			$resultado = $obj->$operacao(); 
			echo $resultado; 
			exit;
		} 
		else 
		{
			echo json_encode(["erro" => "Operação não encontrada"]);
			exit;
		}
	}

    // NOVO ROTEADOR POST (para inserir_area_rest)
   if($_POST)
    {
        if(isset($_POST["oper"]))
        {
            $obj = new PlantacaoRest();
            $metodo = $_POST["oper"];
			if($metodo == "inserir_area_rest")
			{
                // 1. Coletar os dados do POST
                // (O construtor espera tipos específicos: int, string, float)
                $unidade = $_POST['unidade'];
                $latitude = $_POST['latitude'];
                $longitude = $_POST['longitude'];
                $medida = (float)$_POST['medida'];
				 $area = new Area(
                    0,
                    $unidade,
                    $latitude,
                    $longitude,
                    $medida
                );
				$ret = $obj->$metodo($area); 
				exit($ret); 
			 }
        }
    }
	
?>