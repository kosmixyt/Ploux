<?php
require("token_verif.php");
if(empty($_SESSION["id"])){



$tableau = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href=\"#\" class='headbutton' onClick=\"verify()\" >Acceuil</a>
<a href=\"#login\" onClick=\"verify()\"  class='headbutton'  >Se connecter</a>";


}else{





  $tableau = "
  <a href=\"#account\" onClick=\"verify()\"  class='headbutton'  >Mon compte</a>
  <a href=\"#\" onClick=\"verify()\"  class='headbutton'  >Acceuil</a>
  <a href=\"#newmedia\" onClick=\"verify()\"  class='headbutton'  >Nouveau média</a>
  ";
}





?>







<header>
<h1 class="godtitle">Plex media center</h1>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $tableau;

?>
  <div class="menu-links">
    <ul class="toggle-menu">
      <li class="toggle">
      </li>
      <li class="content" style="display: none;">


      </li>
    </ul>
  </div>
</header>
