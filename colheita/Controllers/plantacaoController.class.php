<?php 
    class plantacaoController{

         // Este método apenas busca dados (GET).
        public function tabelaPlantacaoRest()
        {
            // O serviço REST (plantacaoRest.class.php) precisa 
            // estar com o roteamento GET descomentado 
            $retorno = file_get_contents("http://localhost/plantacao/services/PlantacaoRest.class.php?oper=Buscar_Plantacao");
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
    }
?>