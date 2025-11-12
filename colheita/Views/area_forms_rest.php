<!doctype html>
<html>
    <head>
        <title>Áreas</title>
        <meta charset="utf-8">
        <style>
            /* Mesmo estilo do formulário anterior para consistência */
            body { font-family: sans-serif; margin: 20px; }
            h1 { color: #333; }
            form { border: 1px solid #ccc; padding: 20px; border-radius: 8px; max-width: 400px; }
            div { margin-bottom: 15px; }
            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
            }
            input[type="text"],
            input[type="number"] {
                width: 100%;
                padding: 8px;
                box-sizing: border-box; /* Garante que o padding não quebre o layout */
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            button {
                background-color: #28a745; /* Cor verde para diferenciar */
                color: white;
                padding: 10px 15px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }
            button:hover {
                background-color: #218838;
            }
        </style>
    </head>
    <body>
        <h1>Inserir Área (REST)</h1>
        
        <form action="index.php?controle=colheitaController&metodo=salvarAreaRest" method="POST">
            
            <div>
                <label for="medida">Medida (Tamanho):</label>
                <input type="number" id="medida" name="medida" step="0.01" required>
            </div>

            <div>
                <label for="unidade">Unidade (ex: Hectares, m²):</label>
                <input type="text" id="unidade" name="unidade" required>
            </div>

            <div>
                <label for="latitude">Latitude (ex: -21.1234):</label>
                <input type="number" id="latitude" name="latitude" step="any" required>
            </div>

            <div>
                <label for="longitude">Longitude (ex: -48.5678):</label>
                <input type="number" id="longitude" name="longitude" step="any" required>
            </div>
            
            <button type="submit">Salvar Área (REST)</button>
        </form>
    </body>
</html>