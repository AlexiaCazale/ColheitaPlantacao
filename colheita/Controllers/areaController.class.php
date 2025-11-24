<?php 
    class areaController{

      	public function inserirAreaRest()
        {
            require_once "Views/area_forms_rest.php";
        }

          public function salvarAreaRest()
        {
            // 1. A URL do serviço REST (plantacaoRest.class.php)
            $url = "http://localhost/plantacao/services/PlantacaoRest.class.php";

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