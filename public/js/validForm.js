let inputImage=document.getElementById("serie_image");
inputImage.addEventListener("change",function(event){   
    console.log(event.target.value)
    /* if (event.target.value.search(".jpg")!=-1 || event.target.value.search(".png")!=-1){
        console.log("La saisie est correcte")
    } 
    else {
        console.log("La saisie est incorrecte")
    } */
// OU
    let regex = /(\.png|\.jpg)$/;
    let image = event.target.value;
    let span = document.getElementById("erreur");
    let btnajouter = document.getElementsByClassName("btn btn-primary");
    if (image.search(regex)>-1){
        //console.log("La saisie est correcte")
        span.innerHTML = "";
        btnajouter[0].disabled = false;

    }
    else {
        //console.log("La saisie est incorrecte")
        span.innerHTML = "Le fichier doit être au format .jpg ou .png";
        btnajouter[0].disabled = true;
    }
});


