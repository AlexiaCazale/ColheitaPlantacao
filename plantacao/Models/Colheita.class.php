<?php
    class Colheita{
        public function __construct(private int $idcolheita = 0, private string $unidade = "", private float $quantidade = 0, private dateTime $data_colheita, private Plantacao $plantacao = new Plantacao(), private Area $area = new Area()){}
		
        public function getIdColheita()
		{
			return $this->idcolheita;
		}

        public function getUnidade()
		{
			return $this->unidade;
		}

        public function getQuantidade()
		{
			return $this->quantidade;
		}

        public function getDataColheita()
		{
			return $this->data_colheita;
		}

        public function getArea()
		{
			return $this->area;
		}

        public function getPlantacao()
		{
			return $this->plantacao;
		}
    }
?>