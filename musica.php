<?php
    session_start();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Música</title>
    
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="contenedorGridMenuContenido">

        


        <div>

            <div class="contenedorDivs">
                <div class="divContenidoGrid">

                    
                    <label id="labelTituloEstadosAnimo" for="opciones">Estados de ánimo:</label><br>
                    <select id="desplegableOpciones" name="opciones">
                        <option value="selecciona">Selecciona una opción</option>
                        <option value="contento">😀 Contento</option>
                        <option value="enfadado">😡 Enfadado</option>
                        <option value="triste">😢 Triste</option>
                        <option value="enamorado">🥰 Enamorado</option>
                        <option value="sorprendido">😯 Sorprendido</option>
                    </select>

                    <br><br>

                    <?php

                        if ($_SESSION['rol'] == 'administrador'){
                            echo '<button id="buttonPanelDeControl" class="buttonPanelDeControl" onclick="window.location.href=\'dashboard.php\'">Panel de control</button>';
                        }


                    ?>
                    
                </div>

                <div class="divContenidoGrid">

                    <img id="imageViewDiscoCancion" class="imagenDisco">

                    <br><br>

                    <div class="cajaTituloArtista">
                        <h2 id="textViewTituloCancion" class="textViewTituloCancion"></h2>
                        <h3 id="textViewArtistaCancion" class="textViewArtistaCancion"></h3>
                    </div>


                    <br><br>

                    <input type="range" id="barraTiempo" class="barraTiempo" min="0" value="0">
                    <span id="tiempoActual">0:00</span> / <span id="duracionTotal">0:00</span>

                    <br><br><br>

                    <div class="divBotonesReproductor">
                        <button id="botonPistaAnterior"></button>
                        <button id="botonPlayPause"></button>
                        <button id="botonPistaSiguiente"></button>
                    </div>
                </div>


                <div class="divContenidoGrid">
                    <h1 class="textoBlanco">Lista de reproducción</h1>

                    <div id="listViewListaReproduccion" class="listaDeReproduccion">
                    </div>

                    <div class="configuracion">
                        <div class="divConfiguraciones">

                            

                            <label class="labelBarras">Volumen</label>
                            <input type="range" id="barraVolumen" class="barrasConfiguracion" min="0" max="1" step="0.01">

                            <label class="labelBarras" hidden>Agudos</label>
                            <input hidden type="range" id="barraAgudos" class="barrasConfiguracion" min="0" max="20" step="1" value="0">

                            <label hidden class="labelBarras">Graves</label>
                            <input hidden type="range" id="barraGraves" class="barrasConfiguracion" min="0" max="20" step="1" value="0">
                        
                            <br><br>
                        
                            <canvas id="equalizer" class="equalizer"></canvas>
                        </div>

                        
                        
                        
                                        
                    </div>
                </div>



            </div>

        </div>

        
    </div>

</body>
<script type="module" src="scripts/scriptMusica.js" defer></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/howler@2.2.3/dist/howler.min.js"></script>
</html>