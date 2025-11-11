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
	}

	if (isset($_GET['oper'])) {
		$operacao = $_GET['oper'];
		$obj = new PlantacaoRest();
	
		if (method_exists($obj, $operacao)) {
			$resultado = $obj->$operacao();
			echo $resultado; // Envia a resposta JSON
			exit; // Termina a execução
		} else {
			echo json_encode(["erro" => "Operação não encontrada"]);
			exit;
		}
	}
		// if($_POST)
		// {	
		// 	if(isset($_POST["oper"]))
		// 	{
		// 		$obj = new EditoraRest();
		// 		$metodo = $_POST["oper"];
				
		// 		if($metodo == "buscar_por_autor")
		// 		{

		// 			$ret = $obj->$metodo($_POST["nome"]);
		// 			exit($ret);
		// 		}
		// 	}
		// }
	
?>