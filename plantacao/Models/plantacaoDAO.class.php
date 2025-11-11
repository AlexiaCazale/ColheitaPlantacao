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
			$sql = "INSERT INTO area(idarea, medida, unidade, latitude, longitude) VALUES (:id, :medida, :unidade, :latitude, :longitude);";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->execute(
					[
						"id" -> $area->getIdArea(),
						"medida" -> $area->getMedida(),
						"unidade" -> $area->getMedida(),
						"latitude" -> $area->getLatitude(),
						"longitude" -> $area->getLongitude()
					]
				);
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				return "Problema ao inserir a area";
			}
		}
		public function inserir_colheita_soap(Colheita $colheita)
		{
			$sql = "INSERT INTO area(idcolheita, idarea, idplantacao, data_colheita, quantidade, unidade) VALUES (:id, :id_area, :id_plantacao, :data_plantacao, :quantidade, :unidade);";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->execute(
					[
						"id" -> $colheita->getIdColheita(),
						"id_area" -> $colheita->getArea()->getIdArea(),
						"id_plantacao" -> $colheita->getPlantacao()->getIdPlantacao(),
						"data_plantacao" -> $colheita->getDataColheita(),
						"quantidade" -> $colheita->getQuantidade(),
						"unidade" -> $colheita->getUnidade()
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