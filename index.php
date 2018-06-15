<?php
/**
 * Created by PhpStorm.
 * User: Christian Reis
 * Date: 14/06/2018
 * Time: 14:45
 */

session_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_erros','On');

require 'vendor/autoload.php';
require 'config/config.php';
require 'config/constants.php';

$app = new \Slim\App;
$app = new \Slim\App(["settings" => $config]); //importa as configurações
$container = $app->getContainer(); //cria container

$container['view'] = new \Slim\Views\PhpRenderer('resources/views/'); //adicona no conteiner o path das views do projeto


$container['db'] = function($c){  //configura o banco e adiciona no conteiner
    $db = $c['settings']['db'];

    $pdo = new PDO("mysql:host=".$db['host'].";dbname=".$db['dbname'],$db['user'],$db['pass']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

    return $pdo;
};

require 'App/routes.php';//adiconar arquivo das rotas


$app->run(); //inicia a aplicação
