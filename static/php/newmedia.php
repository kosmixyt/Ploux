<?php
session_start();
require("token_verif.php");

if($logged == false){
    echo '{"status":"error", "errors":"notconnected"}';
    die;
}



?>

<h1>Nouveau média</h1>

<style>

#drag_drop{
    background-color : #f9f9f9;
    border : #ccc 4px dashed;
    line-height : 100px;
    
    padding : 12px;
    font-size : 24px;
    text-align : center;

}
</style>

<p><div class="container">

            <div id="card"class="card">
                <div  id="form_upload"class="card-body">
                    <div class="row">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-6">
                            <div id="drag_drop" style='font-size: 20px;'>Déplacer votre média ici (drag & drop file here)</div>
                        </div>
                        <div class="col-md-3">&nbsp;</div>
                    </div>
                </div>
            </div>
            <br />
            <div class="progress" id="progress_bar" style="display:none; height:50px;">
                <div class="progress-bar bg-success" id="progress_bar_process" role="progressbar" style="width:0%; height:50px;">0%

                </div>
            </div>
            <div id="uploaded_image" class="row mt-5"></div>
        </div>
<p> Importer les caractéristique depuis <a  class="linkdb" href="https://www.themoviedb.org">The movide database </a><input type="checkbox" name="imdbouiounon" id="imdbouiounon" onChange="imdb()" > (privilégié tmdb car il importe automatiquement le nom des acteurs et + encore)</p>

<div id="imdbparams">

<h4>Fichier mp4/mkv/avi du média : </h4>

<h4>Média : </h4>
<h4>Nom du média</h4>
<input type="text" id="media_name">
<h4>Date de création du média</h4>
<input type="number" value="<?php echo date("Y"); ?>" id="date_name">
<h4>Description du média </h4>
<textarea rows="10"  id="media_desc"cols="75" name="media_desc"></textarea>
<h1 id="ef"></h1>



</div>
<p>Soumettre automatiquement à la fin de l'upload <input type="checkbox" id="submitonfinish" onChange="submitfinish();" ></p>
<button name="submitnewmedia" onclick="submit_new_media()" >Envoyer </button>
</p><br>



