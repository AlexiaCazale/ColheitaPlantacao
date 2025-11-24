<?php
class areaDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function inserir_area($area){
        $sql = "INSERT INTO area (medida, unidade, latitude, longitude) VALUES (?, ?, ?, ?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm -> bindValue(1, $area->getMedida());
            $stm -> bindValue(2, $area->getUnidade());
            $stm -> bindValue(3, $area->getLatitude());
            $stm -> bindValue(4, $area->getLongitude());
            $stm->execute();
            $this->db = null;
            return true;
        } catch (Exception $e) {
            $this->db = null;
            return "Problema ao inserir a area";
        }
    }

     public function buscar_todas_areas(){
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
}
?>