<?php 
    class colheitaController{
        public function tabelaPlantacaoRest()
		{
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
			$retorno = file_get_contents("http://localhost/plantacao/services/plantacaoRest.class.php?oper=inserir_area_rest");
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

        public function inserirColheitaSoap()
		{
            $retorno = file_get_contents("http://localhost/plantacao/services/plantacaoRest.class.php?oper=inserir_colheita_soap");
            var_dump($retorno);
			$retorno = json_decode($retorno);
			if(is_array($retorno))
			{
				require_once "Views/listar_colheitas.php";
			}
			//else
			//{
			//	echo $retorno;
			//}
		}

    }

?>