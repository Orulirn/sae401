<!DOCTYPE html>
<html>
<head>
    <title>Classement Tournoi</title>
    <meta charset="UTF-8">
    <title>Création tournoi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style id="monStyle">
        @keyframes scroll-right {
            0% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(-100px);
                opacity: 0;
            }
            51% {
                transform: translateX(100px);
                opacity: 0;
            }
        }
        @keyframes scroll-left {
            0% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(100px);
                opacity: 0;
            }
            51% {
                transform: translateX(-100px);
                opacity: 0;
            }
        }
        .btn-toolbar{
            height: max-content;
            overflow-x: hidden;
            white-space: nowrap;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            align-items: center;
            box-sizing: border-box;
        }
        .tableau{
            margin: 5%;
            text-align: center;
        }
        .scrollBarTop {
            display: flex;
            flex-wrap: nowrap;
            margin-left: 15px;
            margin-top: 15px;
        }
        .btnClassement{
            margin-right: 10px;
        }
        .btn-outline-dark{
            display: inline-block;
            color: #1a1d20;
            border-color: white;
            border-radius:50%;
        }
        .flecheGaucheDiv{
            display: flex;
            justify-content: flex-end;
        }
        .flecheDroiteDiv{
            display: flex;
            text-align: left;
        }
        .btnRight{
            margin-left: 15px;
        }
        .btnLeft{
            margin-right: 15px;
        }
    </style>
</head>
<br>
<div id="scrollBarTop" class="scrollBarTop">
    <div id="flecheGaucheDiv" class="flecheGaucheDiv">
        <button onclick="slideLeft()" class="btn btn-outline-dark btnLeft" id="buttonLeft"> < </button>
    </div>
    <div class="btn-toolbar" role="toolbar" style="margin: 0" id="btnToolbar">
        <div class="mr-2" id="btnGroupAfficher" >
            <?php
            global $tournois;
            $i=0;
            foreach($tournois as $tournoi){
                echo '<button type="button" class="btn btn-outline-secondary btnClassement"
    onclick="GetResultAjax('.$tournoi["idTournoi"].')">'.$tournoi["place"]." | ".$tournoi["year"].'
    </button>';

            }
            ?>
        </div>
    </div>
    <div class="flecheDroiteDiv" id="flecheDroiteDiv" >
        <button onclick="slideRight()" class="btn btn-outline-dark btnRight" id="buttonRight"> > </button>
    </div>
</div>
<script>
    let button=null
    const  boutonGroup=document.getElementById("btnToolbar")
    function checkTel(){
        if( navigator.userAgent.match(/iPhone/i)
            || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/Android/i)
            || navigator.userAgent.match(/iPad/i)
            || navigator.userAgent.match(/iPod/i)
            || navigator.userAgent.match(/BlackBerry/i)
            || navigator.userAgent.match(/Windows Phone/i)
            ){
                return true;
            }
            else {
                return false;
            }
    }

    window.onload=function(){
        let tailleFenetre = [window.innerHeight,window.innerWidth]
        let flecheGaucheDiv = document.getElementById("flecheGaucheDiv")
        let flecheDroiteDiv = document.getElementById("flecheDroiteDiv")
        if(!checkTel()) {
            flecheGaucheDiv.style.width = (tailleFenetre[1] / 12).toString() + "px"
            flecheDroiteDiv.style.width = (tailleFenetre[1] / 12).toString() + "px"
            boutonGroup.style.width = (tailleFenetre[1] / 1.25).toString() + "px"
        }else{
            boutonGroup.style.width="100vw"
            boutonGroup.style.margin = "0";
            boutonGroup.style.padding = "0";
            boutonGroup.style.overflowX="auto"
            var btns=document.querySelectorAll(".btnClassement")
            for(let i of btns){
               i.style.fontSize="24px"
            }
            let scrollbarTop=document.getElementById("scrollBarTop");
            scrollbarTop.removeChild(flecheDroiteDiv)
            scrollbarTop.removeChild(flecheGaucheDiv)
        }

    }

    window.onresize=function () {
        let tailleFenetre = [screen.height, screen.width]
        let flecheGaucheDiv = document.getElementById("flecheGaucheDiv")
        let flecheDroiteDiv = document.getElementById("flecheDroiteDiv")
        if(!checkTel()) {
            flecheGaucheDiv.style.width = (tailleFenetre[1] / 12).toString() + "px"
            flecheDroiteDiv.style.width = (tailleFenetre[1] / 12).toString() + "px"
            boutonGroup.style.width = (tailleFenetre[1] / 1.25).toString() + "px"
        }else{
            boutonGroup.style.width="100vw"
        }
    }

    function GetResultAjax(idtournoi){
        event.target.style.backgroundColor="#6c757d"
        event.target.style.color="#ffffffff"
        if(button===null){
            button=event.target
        }
        else if (button!==event.target){
            button.style.backgroundColor="#ffffff"
            button.style.color="#6c757d"
            button=event.target
        }
        $.ajax({
            url:"../Controller/AjaxClassement.php",
            type:"POST",
            data:{idtournoi:idtournoi},
            success: function (response){
                apparitionTableau(response)
            },
            error: function (error){
                console.error(error)
            }
        })
    }


    function apparitionTableau(response){
        var result=response.split("\n")

        if (document.getElementById('tableau')) {
            document.body.removeChild(document.getElementById("tableau"))
        }

        var div=document.createElement("div")
        div.id="tableau"
        div.className="tableau"
        var table=document.createElement("table")
        table.className="table table-striped table-responsive table-bordered"
        div.appendChild(table)

        var thead=document.createElement("thead")
        thead.className="thead-light"
        var tr=document.createElement("tr")

        var thClassement=document.createElement("th")
        thClassement.scope="col"
        thClassement.textContent=""
        tr.appendChild(thClassement)

        var thEquipe=document.createElement("th")
        thEquipe.scope="col"
        thEquipe.textContent="Equipe"
        tr.appendChild(thEquipe)

        var thVictoire=document.createElement("th")
        thVictoire.scope="col"
        thVictoire.textContent="Victoire"
        tr.appendChild(thVictoire)

        var thDefaite=document.createElement("th")
        thDefaite.scope="col"
        thDefaite.textContent="Defaite"
        tr.appendChild(thDefaite)
        thead.appendChild(tr)

        table.appendChild(thead)
        document.body.appendChild(div)

        var tbody=document.createElement("tbody")
        table.appendChild(tbody)
        for(let i of result) {
            let result = i.split("/")
            if (result.length!==1) {
                var trbody = document.createElement("tr")
                tbody.appendChild(trbody)
                for (let j of result) {
                    if (j!=="") {
                        var td = document.createElement("td")
                        td.textContent = j
                        trbody.appendChild(td)
                    }
                }
            }
        }
        if(checkTel()){
            thead.style.fontSize="22px"
            tbody.style.fontSize="22px"
        }
    }


    function slideRight(){
        boutonGroup.style.animation="scroll-right 0.5s ease-in-out"
        setTimeout(function (){
            boutonGroup.style.animation=""
        },500)
        setTimeout(function (){
            boutonGroup.scrollLeft+=boutonGroup.offsetWidth
        },250)
        if (boutonGroup.scrollLeft===boutonGroup.offsetHeight){
            
        }
    }
    function slideLeft(){
        boutonGroup.style.animation="scroll-left 0.5s ease-in-out"
        setTimeout(function (){
            boutonGroup.style.animation=""
        },500)
        setTimeout(function (){
            boutonGroup.scrollLeft-=boutonGroup.offsetWidth
        },250)
    }

</script>
<body>
