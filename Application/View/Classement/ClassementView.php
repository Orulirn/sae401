<!DOCTYPE html>
<html>
<head>
    <title>Classement Tournoi</title>
    <meta charset="UTF-8">
    <title>Création tournoi</title>
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
    </div>
    <div class="btn-toolbar" role="toolbar" style="margin: 0" id="btnToolbar">
        <div class="mr-2" id="btnGroupAfficher" >
            <?php
            global $tournois;
            $i=0;
            foreach($tournois as $tournoi){
                echo '<button type="button" class="btn btn-outline-secondary btnClassement" id="'.$tournoi["idTournoi"].'"
    onclick="GetResultAjax('.$tournoi["idTournoi"].')">'.$tournoi["place"]." | ".$tournoi["year"].'
    </button>';

            }
            ?>
        </div>
    </div>
    <div class="flecheDroiteDiv" id="flecheDroiteDiv" >
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
            /*boutonGroup.style.width=(tailleFenetre[1]/1.2).toString()+"px"*/
            if(boutonGroup.offsetWidth<boutonGroup.scrollWidth){
                let btnright=document.createElement("button")
                btnright.addEventListener("click",function (){
                    slideRight()
                });
                btnright.textContent=" > "
                btnright.className="btn btn-outline-dark btnRight"
                btnright.id="buttonRight"
                document.getElementById("flecheDroiteDiv").appendChild(btnright)
            }
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
        var btns2=document.querySelectorAll(".btnClassement")
        GetResultAjax(btns2[0].id)

    }

    window.onresize=function () {
        let tailleFenetre = [screen.height, screen.width]
        let flecheGaucheDiv = document.getElementById("flecheGaucheDiv")
        let flecheDroiteDiv = document.getElementById("flecheDroiteDiv")
        if(!checkTel()) {
            flecheGaucheDiv.style.width = (tailleFenetre[1] / 12).toString() + "px"
            flecheDroiteDiv.style.width = (tailleFenetre[1] / 12).toString() + "px"
        }else{
            boutonGroup.style.width="100vw"
        }
    }

    function GetResultAjax(idtournoi){
        console.log(event.target.textContent)
        if (event.target.textContent) {
            event.target.style.backgroundColor = "#6c757d"
            event.target.style.color = "#ffffffff"
            if (button === null) {
                button = event.target
            } else if (button !== event.target) {
                button.style.backgroundColor = "#ffffff"
                button.style.color = "#6c757d"
                button = event.target
            }
        }else{
            let btns=document.querySelectorAll(".btnClassement")
            for (let btn of btns){
                if (btn.id===idtournoi){
                    btn.style.backgroundColor="#6c757d"
                    btn.style.color="#ffffffff"
                    button=btn
                }
            }
        }
        $.ajax({
            url:"AjaxClassementVictoire.php",
            type:"POST",
            data:{idtournoi:idtournoi},
            async : false,
            success: function (response){
                apparitionTableauVictoire(response)
            },
            error: function (error){
                console.error(error)
            }
        })
        $.ajax({
            url:"AjaxClassementBut.php",
            type: "POST",
            data:{idtournoi:idtournoi},
            async: false,
            success: function (response) {
                apparitionTableauBut(response)
            },
            error:function (error){
                console.error(error)
            }
        })
    }


    function apparitionTableauVictoire(response){
        var result=response.split("\n")
        if (document.getElementById('tableauVictoire')) {
            document.body.removeChild(document.getElementById("tableauVictoire"))
        }

        var div=document.createElement("div")
        div.id="tableauVictoire"
        div.className="tableau"
        var h1=document.createElement("h1")
        h1.textContent="Classement du tournoi de "+button.textContent
        div.appendChild(h1)
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

    function apparitionTableauBut(response){
        var result=response.split("\n")

        if (document.getElementById('tableauBut')) {
            document.body.removeChild(document.getElementById("tableauBut"))
        }

        var div=document.createElement("div")
        div.id="tableauBut"
        div.className="tableau"

        var h1=document.createElement("h1")
        h1.textContent="Classement des meilleurs buteurs"
        div.appendChild(h1)

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

        var thBut=document.createElement("th")
        thBut.scope="col"
        thBut.textContent="But"
        tr.appendChild(thBut)

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
            boutonGroup.scrollLeft+=Math.round(boutonGroup.offsetWidth)
            boutonGroup.scrollLeft=Math.round(boutonGroup.scrollLeft)
            console.log(boutonGroup.scrollLeft,boutonGroup.offsetWidth,boutonGroup.scrollWidth)
            if (boutonGroup.scrollLeft + boutonGroup.offsetWidth +10 >= boutonGroup.scrollWidth) {
                document.getElementById("flecheDroiteDiv").removeChild(document.getElementById("buttonRight"))
            }
            if(!document.getElementById("buttonLeft")){
                let btnleft=document.createElement("button")
                btnleft.addEventListener("click",function (){
                    slideLeft()
                });
                btnleft.textContent=" < "
                btnleft.className="btn btn-outline-dark btnLeft"
                btnleft.id="buttonLeft"
                document.getElementById("flecheGaucheDiv").appendChild(btnleft)
            }
        },250)
    }
    function slideLeft(){
        boutonGroup.style.animation="scroll-left 0.5s ease-in-out"
        setTimeout(function (){
            boutonGroup.style.animation=""
        },500)
        setTimeout(function (){
            boutonGroup.scrollLeft-=boutonGroup.offsetWidth
            if (boutonGroup.scrollLeft===0){
                document.getElementById("flecheGaucheDiv").removeChild(document.getElementById("buttonLeft"))
            }
            if(!document.getElementById("buttonRight")){
                let btnright=document.createElement("button")
                btnright.addEventListener("click",function (){
                    slideRight()
                });
                btnright.textContent=" > "
                btnright.className="btn btn-outline-dark btnRight"
                btnright.id="buttonRight"
                document.getElementById("flecheDroiteDiv").appendChild(btnright)
            }
        },250)
    }

</script>
<body>
