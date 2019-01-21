<?php

$user_id = $_GET['id'];
$token = $_GET['token'];
require 'inc/db.php';

$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();

if($user && $user->confirmation_token == $token){
	
	$pdo->prepare('UPDATE users SET confirmation_token = NULL,confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
	$_SESSION['flash']['success'] = 'compte validé';
	$_SESSION['auth'] = $user;
	header('Location: account.php');
	die('ok');


}else{
	$_SESSION['flash']['danger'] = 'ce token plus valide';
	header('Location: login.php');
}