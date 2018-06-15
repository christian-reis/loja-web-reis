<?php
/**
 * Created by PhpStorm.
 * User: Christian Reis
 * Date: 14/06/2018
 * Time: 17:44
 */

namespace App\Middleware\Admin;

class AuthMiddleware
{
    public function __invoke($request, $response, $next){//função que verifica se foi logado ou não e redireciona se for o caso
        if(!isset($_SESSION[PREFIX.'logado']))
            return $response->withRedirect(PATH.'/login');

        $response = $next($request,$response);

        return $response;

    }
}