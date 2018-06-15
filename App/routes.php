<?php
/**
 * Created by PhpStorm.
 * User: Christian Reis
 * Date: 14/06/2018
 * Time: 15:17
 */


//ADMIN

$app->group('/admin',function (){
    $this->get('/products','App\Action\Admin\ProductAction:index');
    $this->get('/product/add','App\Action\Admin\ProductAction:viewadd');
    $this->post('/product/add','App\Action\Admin\ProductAction:saveadd');
    $this->get('/product/{id}/edit','App\Action\Admin\ProductAction:viewedit');
    $this->post('/product/{id}/edit','App\Action\Admin\ProductAction:saveedit');
    $this->get('/product/{id}/view','App\Action\Admin\ProductAction:view');
    $this->get('/product/{id}/delete','App\Action\Admin\ProductAction:delete');

    $this->get('/product/successedit','App\Action\Admin\ProductAction:successedit');
    $this->get('/product/erroredit','App\Action\Admin\ProductAction:erroredit');

    $this->get('/product/successdelete','App\Action\Admin\ProductAction:successdelete');
    $this->get('/product/errordelete','App\Action\Admin\ProductAction:errordelete');

})->add(App\Middleware\Admin\AuthMiddleware::class);
//$app->get('/admin/products','App\Action\Admin\ProductAction:index');

//PUBLICO

$app->get('/','App\Action\HomeAction:index');//rota para tela home publica
$app->get('/login','App\Action\Admin\LoginAction:index'); //rota para carregar tela de login
$app->post('/login', 'App\Action\Admin\LoginAction:login'); //rota para realizar login
$app->get('/logout','App\Action\Admin\LoginAction:logout');//sair da conta encerrando sessão

