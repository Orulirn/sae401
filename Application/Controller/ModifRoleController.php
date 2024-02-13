<?php
session_start();
include "../Model/UsersModel.php";

$id = $_GET['buttonIndex'];
$role = $_GET['role'];

UpdateRoleAdmin($id,$role);

header('Location: ModificationController.php');

?>