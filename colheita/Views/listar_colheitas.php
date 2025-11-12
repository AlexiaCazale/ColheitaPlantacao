<!doctype html>
<html>
	<head>
		<title>Colheitas</title>
		<meta charset="utf-8">
	</head>
	<body>
		<h1>Lista de Plantações</h1>
		<br>
		<table border="1">
			<tr>
				<th>idPlantacao</th>
				<th>Descritivo</th>
			</tr>
		<?php
			foreach($retorno as $dado)
			{
				echo "<tr>
						<td>{$dado->idplantacao}</td>
						<td>{$dado->descritivo}</td>
					  </tr>";
			}
		?>
		</table>
	</body>
</html>