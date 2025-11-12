<?php
	abstract class Conexao
	{
		public function __construct(protected $db = null)
		{
			$parametros = "mysql:host=localhost;port=3307;dbname=plantacao;charset=utf8mb4";
			try
			{
			$this->db = new PDO($parametros, "root", "root");
			}
			catch(PDOException $e)
			{
				return "Tente mais tarde!!!";
			}
		}
		
	}
?>