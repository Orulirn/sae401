<!DOCTYPE html>
<html>
<head>
    <title>Classement Tournoi</title>
    <meta charset="UTF-8">
    <title>Création tournoi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .btn-toolbar{
            height: max-content;
            overflow-x: hidden;
            white-space: nowrap;
        }
        .tableau{
            margin: 5%;
            text-align: center;
        }
        .scrollBarTop {
            display: flex;
            flex-wrap: nowrap;
            margin: 15px;
        }
        .btn{
            margin-right: 10px;
        }

    </style>
</head>
<br>
<div id="scrollBarTop" class="scrollBarTop">
    <div id="flecheGaucheDiv" class="flecheGaucheDiv">
        <button onclick="slideLeft()"> < </button>
    </div>
    <div class="btn-toolbar" role="toolbar" style="margin: 0" id="btnToolbar">
        <div class="mr-2" id="btnGroupAfficher" >
            <?php
            global $tournois;
            $i=0;
            foreach($tournois as $tournoi){
                echo '<button type="button" class="btn btn-outline-secondary"
    onclick="GetResultAjax('.$tournoi["idTournoi"].')">'.$tournoi["place"]." | ".$tournoi["year"].'
    </button>';

            }
            ?>
        </div>
    </div>
    <div class="" id="flecheDroiteDiv" >
        <button onclick="slideRight()"> > </button>
    </div>
</div>
<script>
    let button=null
    const  boutonGroup=document.getElementById("btnToolbar")
    window.onload=function(){
        let tailleFenetre=[window.innerHeight,window.innerWidth]

        let fleceGaucheDiv=document.getElementById("flecheGaucheDiv")
        fleceGaucheDiv.style.width=(tailleFenetre[1]/12).toString()+"px"


        boutonGroup.style.width=(tailleFenetre[1]/1.2).toString()+"px"
    }
    window.onresize=function () {
        let tailleFenetre=[window.innerHeight,window.innerWidth]

        let fleceGaucheDiv=document.getElementById("flecheGaucheDiv")
        fleceGaucheDiv.style.width=(tailleFenetre[1]/12).toString()+"px"


        boutonGroup.style.width=(tailleFenetre[1]/1.2).toString()+"px"
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
    }


    function slideRight(){
        boutonGroup.scrollLeft+=boutonGroup.offsetWidth

    }
    function slideLeft(){
        boutonGroup.scrollLeft-=boutonGroup.offsetWidth

    }

</script>
<body>
