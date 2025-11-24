<?php
class colheitaDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function inserir_colheita_soap($colheita){
        $sql = "INSERT INTO colheita (idarea, idplantacao, data_colheita, quantidade, unidade) VALUES (?, ?, ?, ?, ?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm -> bindValue(1, $colheita->getArea()->getIdArea());
            $stm -> bindValue(2, $colheita->getPlantacao()->getIdPlantacao());
            $stm -> bindValue(3, $colheita->getDataColheita());
            $stm -> bindValue(4, $colheita->getQuantidade());
            $stm -> bindValue(5, $colheita->getUnidade());
            $stm->execute();
            $this->db = null;
            return $stm -> fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            $this->db = null;
            return "Problema ao inserir a colheita";
        }
    }
}
?>