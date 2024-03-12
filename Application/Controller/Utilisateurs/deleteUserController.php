<?php
session_start();
include "../../Model/Utilisateur/UsersModel.php";

$id = $_GET['buttonIndex'];

deleteUser($id);


header('Location: ModificationController.php');
