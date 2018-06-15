<?php
/**
 * Created by PhpStorm.
 * User: Christian Reis
 * Date: 14/06/2018
 * Time: 17:24
 */

namespace App\Action\Admin;


use App\Action\Action;

class LoginAction extends Action
{
    public function index($request, $response){//renderiza a tela de login
        if(isset($_SESSION[PREFIX.'logado'])){
            return $response->withRedirect(PATH.'/admin/products');
        }
        //return $this->view->render($response,'admin/login/login.phtml');

        $vars['title'] = 'Faça seu login';
        $vars['page'] = 'login';
        return $this->view->render($response,'template.phtml',$vars);

        //return $this->view->render($response,'page/login.phtml');
    }

    public function login($request, $response){ //realiza o login, faz a operação com o banco de dados
        $data = $request->getParsedBody();

        $email = strip_tags(filter_var($data['email'],FILTER_SANITIZE_STRING));
        $pass = strip_tags(filter_var($data['pass'],FILTER_SANITIZE_STRING));

        if($email != '' && $pass != ''){
            $sql = "SELECT * FROM `user` WHERE email_user = ? AND  pass_user = ?";
            $user = $this->db->prepare($sql);
            $user->execute(array($email,$pass));
            if($user->rowCount() > 0){
                $r = $user->fetch(\PDO::FETCH_OBJ);
                $_SESSION[PREFIX.'logado'] = true;
                $_SESSION[PREFIX.'id_user'] = $r->iduser;
                return $response->withRedirect(PATH.'/admin/products');
            }else{
                $vars['erro'] = 'Você não foi encontrado no sistema.';
                return $this->view->render($response,'admin/login/login.phtml',$vars);
            }

        }else{
            $vars['erro'] = 'Preencha todos os campos.';
            return $this->view->render($response,'admin/login/login.phtml',$vars);
        }
    }

    public function logout($request, $response){ //destroi a sessão, saindo da área administrativa
        unset($_SESSION[PREFIX.'logado']);
        session_destroy();
        return $response->withRedirect(PATH.'/');
    }
}