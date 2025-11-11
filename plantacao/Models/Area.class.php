<?php
    class Area{
        public function __construct(private int $idarea = 0, private string $unidade = "", private string $latitude = "", private string $longitudade = "", private float $medida = 0){}
		
		public function getIdArea()
		{
			return $this->idarea;
		}
		public function getUnidade()
		{
			return $this->unidade;
		}
		public function getLatitude()
		{
			return $this->latitude;
		}
		public function getLongitude()
		{
			return $this->longitudade;
		}
		public function getMedida()
		{
			return $this->medida;
		}
    }
?>