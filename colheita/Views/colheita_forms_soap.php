<!doctype html>
<html>
    <head>
        <title>Colheitas</title>
        <meta charset="utf-8">
        <style>
            body { font-family: sans-serif; margin: 20px; }
            h1 { color: #333; }
            form { border: 1px solid #ccc; padding: 20px; border-radius: 8px; max-width: 400px; }
            div { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; }
            input[type="text"],
            input[type="date"],
            input[type="number"],
            select { /* Adicionado 'select' */
                width: 100%;
                padding: 8px;
                box-sizing: border-box;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            button { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
            button:hover { background-color: #0056b3; }
        </style>
    </head>
    <body>
        <h1>Inserir Colheita (SOAP)</h1>
        
        <form action="index.php?controle=colheitaController&metodo=salvarColheitaSoap" method="POST">
            
            <div>
                <label for="idarea">Área:</label>
                <select id="idarea" name="idarea" required>
                    <option value="">Selecione uma Área</option>
                    <?php 
                        // Loop nos dados que o controller buscou
                        foreach ($retornoAreas as $area) {
                            echo "<option value='{$area->idarea}'>
                                    ID: {$area->idarea} (Medida: {$area->medida} {$area->unidade})
                                </option>";
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="idplantacao">Plantação:</label>
                <select id="idplantacao" name="idplantacao" required>
                    <option value="">Selecione uma Plantação</option>
                    <?php 
                        // Loop nos dados que o controller buscou
                        foreach ($retornoPlantacoes as $plantacao) {
                            echo "<option value='{$plantacao->idplantacao}'>
                                    {$plantacao->descritivo}
                                </option>";
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="data_colheita">Data da Colheita:</label>
                <input type="date" id="data_colheita" name="data_colheita" required>
            </div>

            <div>
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" step="0.01" required>
            </div>

            <div>
                <label for="unidade">Unidade (ex: Kg, Ton, Sacas):</label>
                <input type="text" id="unidade" name="unidade" required>
            </div>
            
            <button type="submit">Salvar Colheita (SOAP)</button>
        </form>
    </body>
</html>