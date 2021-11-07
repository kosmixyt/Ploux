





function get_content (reqtype, url, callback){
  document.getElementById("page_content").innerHTML = "<img src='/static/icon/loading.gif'>";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            returned = this.responseText;

if(typeof(reqtype) !== "undefined" && reqtype == "acc"){

try{
  $par = JSON.parse(this.responseText);
  if($par.errors == "notconnected"){
    document.location.href = "#login";
    
    }

}catch($e){


}



}
            
            document.getElementById("page_content").innerHTML = returned;
            try{
        callback();

            }catch (er){

              
            }
          }
        };
        xmlhttp.open("GET", url ,true);
        xmlhttp.send();


}



alreadydo = false;


function submit_new_media(){


if(upload == false){

  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!, you must drag & drop the media in the area ',

  })

return;
}
if(alreadydo == true){

  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong! please wait the response of the server !',

  })



  return;
}




  if(document.getElementById("imdbouiounon").checked == true){
  url = "/static/php/newmedia_submit.php?type=tmdb&tmdb=" + document.getElementById("tmdb_url").value+"&file_name="+ file_id_name ;
  }else{
    url = "/static/php/newmedia_submit.php?type=manual&file_name="+file_id_name+"name=" + document.getElementById("media_name").value + "&date=" + document.getElementById("date_name").value + "&desc=" + document.getElementById("media_desc").value
  }
  alreadydo = true;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
 if(JSON.parse(this.responseText).statut == "success"){
  Swal.fire(
    'Bon travail !',

    'Le media a été ajouté à la base de donnée !',
    'success'
  )
window.location.href = "/";
 }


    }
  };
  xmlhttp.open("GET", url ,true);
  xmlhttp.send();


}






function page_reset (){

    document.getElementById("page_content").innerHTML = "";

    
}


function verify(filmname){
setTimeout(function () {


    if(window.location.href.includes("#newmedia")){


           get_content("acc", "/static/php/newmedia.php", function(){
             const jqueryScript = document.createElement('script')
           jqueryScript.src = '/static/js/upload.js';
           document.head.append(jqueryScript);
          });
         

        
document.title = "Plex - Nouveau Média";

    }else if(window.location.href.includes("#params")){


        document.title = "Plex - Paramètres";
        page_reset();

    }else if(window.location.href.includes("#login")){



        document.title ="Plex - Login";
get_content("", "/static/php/login.php");


    }else if(window.location.href.includes("#account")){
      get_content("acc", "/static/php/account.php");
      document.title ="Plex - Account management";


    }else if(window.location.href.includes("details")){


      id = window.location.href.substr(window.location.href.search("#details") + 9);
      get_content("", "/static/php/details.php?proxy_id=" + id, () => {
 document.title='Details from : ' + document.getElementById("nameof").innerHTML; 
});


    }else{
      document.title = "Plex"; 
      get_content("", "/static/php/show.php?type=show_global");
 
    }

}, 10);


}

function imdb (){


if(document.getElementById("imdbouiounon").checked == true){
document.getElementById("imdbparams").innerHTML = "<h4><p>the movie database  media url </p></h4><input type=\"url\"  id='tmdb_url' name=\"imdb\">";

}else{
    document.getElementById("imdbparams").innerHTML = "<h4>Nom du média</h4><input type=\"text\" name=\"media_name\"><h4>Date de création du média</h4><input type=\"number\" value=\"\" name=\"date_name\"><h4>Description du média </h4><textarea rows=\"10\" cols=\"75\" name=\"media_desc\"></textarea>";

}



}

verify();


function submit_login (){
 url = "/static/php/login.php?type=login&username="+document.getElementById("usrnm").value+"&pwd="+document.getElementById("pwd").value;

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
try{
mlkm = JSON.parse(this.responseText);
}catch (e){
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: 'Something went wrong!, username or password incorrect',

  })

}

if(JSON.parse(this.responseText).success == "logged"){

  Swal.fire({
    title: 'Successfuly logged !',
    icon: 'success',
    showDenyButton: false,
    showCancelButton: false,
    confirmButtonText: 'Refresh',
    denyButtonText: `Don't save`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
     window.location.href = "/";
    }
  })

}else{
  

}

    }
  };
  xmlhttp.open("GET", url ,true);
  xmlhttp.send();



}


function edit_credential(){




  url = "/static/php/rowupdate.php?mail="+document.getElementById("email_edit").value+"&name="+document.getElementById("name_edit").value+"&lastname="+document.getElementById("lastname_edit").value+"&password="+document.getElementById("password_edit").value;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
if(JSON.parse(this.responseText).status == 'success'){

  get_content("/static/php/account.php");
  document.title ="Plex - Account management";
}else if (JSON.parse(this.responseText).status == 'error invalid password'){

  alert("Mots de passe incorrect  !");
}
    }
  };
  xmlhttp.open("GET", url,true);
  xmlhttp.send();

}

function makeid() {
  var result           = '';
  var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < 25; i++ ) {
    result += characters.charAt(Math.floor(Math.random() * 
charactersLength));
 }
 return result;
}


function logout (){


  url = "/static/php/login.php?type=logout";
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
 
window.location.href = "/";
    }
  };
  xmlhttp.open("GET", url,true);
  xmlhttp.send();








}


function filtre (){


  
}




async function gettranslate(){


const res = await fetch("https://translate.argosopentech.com/translate", {
	method: "POST",
	body: JSON.stringify({
		q: document.getElementById("desc").innerHTML,
		source: "en",
		target: "fr"
	}),
	headers: { "Content-Type": "application/json" }
});

objdata = await res.json()
document.getElementById("desc").innerHTML = JSON.parse(JSON.stringify(objdata)).translatedText;
document.getElementById("trbutton").hidden = true;
console.log(objdata);






}

function select (){


}

function submitfinish(){



  if(document.getElementById("submitonfinish").checked == true){

$submitonfinished = true;
  }else{
    $submitonfinished = false;



  }


}