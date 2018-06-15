<?php
/**
 * Created by PhpStorm.
 * User: Christian Reis
 * Date: 14/06/2018
 * Time: 16:07
 */

namespace App\Action;


class HomeAction extends Action
{
    public function index($request, $response){//carrega a lista de produtos publicamente
        $vars['page'] = 'list'; //informa qual view deve ser carregada
        $sql = "SELECT * FROM product ORDER BY id_product DESC"; //consulta

        $products = $this->db->prepare($sql); //prepara a consulta
        $products->execute(); //executa a consulta

        if($products->rowCount() > 0){ //verifica se encontrou produtos
            $vars['products'] = $products->fetchAll(\PDO::FETCH_OBJ);//cria um array de produtos
        }else{
            $vars['empty'] = "Nenhum produto cadastrado!";
        }

        return $this->view->render($response,'template.phtml',$vars);//renderiza os dados na view especifica
    }
}