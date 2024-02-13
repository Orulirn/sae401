<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

include "../Model/ChargerParcoursModel.php";
include "../View/index.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loadSelectedParcours'])) {
    $selectedParcours = $_POST['parcours'];
//$data = selectParticularParcours("parcoursTest");
    $data = selectParticularParcours($selectedParcours);
}
    function dataTransfert($data)
    {
        echo("<p id='data' visibility='hidden' style= 'display :none;'>" . json_encode($data, JSON_UNESCAPED_UNICODE) . "</p>");
    }
dataTransfert($data);
include "../View/ChargerParcours.php";
