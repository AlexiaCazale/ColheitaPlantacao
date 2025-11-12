<?php
    class plantacaoDAO extends Conexao{
        public function __construct()
		{
			parent:: __construct();
		}

        public function buscar_todas_colheitas()
		{
			$sql = "SELECT * FROM colheita";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->execute();
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				return "Problema ao buscar a colheita";
			}
		}

        public function buscar_todas_plantacoes()
		{
			$sql = "SELECT * FROM plantacao";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->execute();
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				return "Problema ao buscar a plantacao";
			}
		}
        
        public function buscar_todas_areas()
		{
			$sql = "SELECT * FROM area";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->execute();
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				return "Problema ao buscar a area";
			}
		}
        public function inserir_area(Area $area)
      {
          // 1. SQL CORRIGIDA: As colunas (4) e os placeholders (4) agora batem.
          //    Removemos o ":id" que estava sobrando.
          $sql = "INSERT INTO area(medida, unidade, latitude, longitude) VALUES (:medida, :unidade, :latitude, :longitude);";
          
          try
          {
              $stm = $this->db->prepare($sql);
              
              // 2. SINTAXE CORRIGIDA: Com => e os 4 parâmetros corretos.
              $stm->execute(
                  [
                      "medida" => $area->getMedida(),
                      "unidade" => $area->getUnidade(),
                      "latitude" => $area->getLatitude(),
                      "longitude" => $area->getLongitude()
                  ]
              );
              
              $this->db = null;

              // 3. RETORNO CORRIGIDO: INSERT não retorna dados via fetchAll.
              return "Area inserida com sucesso";
          }
          catch(PDOException $e)
          {
              $this->db = null;
              return "Problema ao inserir a area: " . $e->getMessage();
          }
      }
		// ... em plantacaoDAO.class.php

		public function inserir_colheita_soap(Colheita $colheita)
		{
			$sql = "INSERT INTO colheita(idarea, idplantacao, data_colheita, quantidade, unidade) VALUES (:id_area, :id_plantacao, :data_plantacao, :quantidade, :unidade);";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->execute(
					[
						"id_area" => $colheita->getArea()->getIdArea(),
						"id_plantacao" => $colheita->getPlantacao()->getIdPlantacao(),
						"data_plantacao" => $colheita->getDataColheita(),
						"quantidade" => $colheita->getQuantidade(),
						"unidade" => $colheita->getUnidade()
					]
				);
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				return "Problema ao inserir a colheita";
			}
		}
    }

?>