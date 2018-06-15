<?php
/**
 * Created by PhpStorm.
 * User: Christian Reis
 * Date: 14/06/2018
 * Time: 17:03
 */

namespace App\Action\Admin;

use App\Action\Action;

class ProductAction extends Action
{
    public function index($request, $response){// carrega a tela de lista de produtos
        $vars['title'] = 'Lista de Produtos';
        $vars['page'] = 'product/list';
        $sql = "SELECT * FROM product ORDER BY id_product DESC";

        $products = $this->db->prepare($sql);
        $products->execute();

        if($products->rowCount() > 0){//envia array com lista de produtos
            $vars['products'] = $products->fetchAll(\PDO::FETCH_OBJ);
        }else{
            $vars['empty'] = "Nenhum produto cadastrado!";//envia mensagem de lista vazia
        }

        return $this->view->render($response,'admin/template.phtml',$vars);
    }

    public function viewadd($request, $response){ //carrea tela com o form de cadastro de produto
        $vars['title'] = 'Novo Produto';
        $vars['page'] = 'product/add';
        return $this->view->render($response,'admin/template.phtml',$vars);
    }

    public function saveadd($request, $response){ // salva o produto novo no banco de dados
        $data = $request->getParsedBody();
        $name = $data['name'];
        $number = $data['number'];
        $idUser = $_SESSION[PREFIX.'id_user'];

        if($name != "" && $number != ""){
            $sql = "INSERT INTO product SET name_product = ?, number_product = ?, id_user = ?";
            $insert = $this->db->prepare($sql);
            $insert->execute(array($name,$number,$idUser));

            $vasr['title'] = 'Novo Produto';
            $vars['page'] = 'product/add';
            $vars['success'] = 'Cadastrado com sucesso! ';

            //return $response->withRedirect(PATH.'/admin/products');
            return $this->view->render($response,'admin/template.phtml',$vars);

        }
        $vasr['title'] = 'Novo Produto';
        $vars['page'] = 'product/add';
        $vars['error'] = 'Preencha todos os campos.';

        return $this->view->render($response,'admin/template.phtml',$vars);
    }

    public function view($request, $response){//carrega a tela de visualizar produto
        $id_product = $request->getAttribute('id');

        if(!is_numeric($id_product)){
            return $response->withRedirect(PATH.'/admin/products');
        }
        $sql = "SELECT * FROM product WHERE id_product = ?";
        $product = $this->db->prepare($sql);
        $product->execute(array($id_product));

        if($product->rowCount() == 0){
            return $response->withRedirect(PATH.'/admin/product');
        }

        $vars['product'] = $product->fetch(\PDO::FETCH_OBJ);
        $vars['title'] = 'Visualizando';
        $vars['page'] = 'product/view';

        return $this->view->render($response,'admin/template.phtml',$vars);
    }

    public function viewedit($request, $response){ //carrega a tela de formulário de alterar produto
        $id_product = $request->getAttribute('id');

        if(!is_numeric($id_product)){
            return $response->withRedirect(PATH.'/admin/products');
        }
        $sql = "SELECT * FROM product WHERE id_product = ?";
        $product = $this->db->prepare($sql);
        $product->execute(array($id_product));

        if($product->rowCount() == 0){
            return $response->withRedirect(PATH.'/admin/products');
        }

        $vars['product'] = $product->fetch(\PDO::FETCH_OBJ);
        $vars['title'] = 'Editar Produto';
        $vars['page'] = 'product/edit';

        return $this->view->render($response,'admin/template.phtml',$vars);
    }


    public function saveedit ($request, $response){ // salva as alterações do produto
        $id_product = $request->getAttribute('id');

        if(!is_numeric($id_product)){
            return $response->withRedirect(PATH.'/admin/products');
        }
        $sql = "SELECT * FROM product WHERE id_product = ?";
        $product = $this->db->prepare($sql);
        $product->execute(array($id_product));

        if($product->rowCount() == 0){
            return $response->withRedirect(PATH.'/admin/products');
        }

        $data = $request->getParsedBody();
        $name = $data['name'];
        $number = $data['number'];

        if($name != "" && $number != ""){
            $sql = "UPDATE product SET name_product = ?, number_product = ? WHERE id_product = ?";
            $up = $this->db->prepare($sql);
            $up->execute(array($name,$number,$id_product));

            if($up->rowCount() > 0){//sucesso ao editar
                return $response->withRedirect(PATH.'/admin/product/successedit');
            }else{//erro ao editar
                return $response->withRedirect(PATH.'/admin/product/erroredit');
            }

        }
        $vasr['title'] = 'Editar Produto';
        $vars['page'] = 'product/edit';
        $vars['error'] = 'Preencha todos os campos.';

        return $this->view->render($response,'admin/template.phtml',$vars);

    }

    public function successedit($request, $response){//se sucesso ao editar, carrega a tela de produtos com mensagem de sucesso
        $vars['title'] = 'Lista de Produtos';
        $vars['page'] = 'product/list';
        $vars['edit_success'] = "Produto alterado com sucesso!";
        $sql = "SELECT * FROM product ORDER BY id_product DESC";

        $products = $this->db->prepare($sql);
        $products->execute();

        if($products->rowCount() > 0){
            $vars['products'] = $products->fetchAll(\PDO::FETCH_OBJ);
        }

        return $this->view->render($response,'admin/template.phtml',$vars);
    }

    public function erroredit($request, $response){//se erro ao editar, carrega a tela de produtos com mensagem de erro
        $vars['title'] = 'Lista de Produtos';
        $vars['page'] = 'product/list';
        $vars['edit_error'] = "Erro ao alterar o produto, tente mais tarde!";
        $sql = "SELECT * FROM product ORDER BY id_product DESC";

        $products = $this->db->prepare($sql);
        $products->execute();

        if($products->rowCount() > 0){
            $vars['products'] = $products->fetchAll(\PDO::FETCH_OBJ);
        }

        return $this->view->render($response,'admin/template.phtml',$vars);
    }

    public function delete($request, $response){//deleta produto
        $id_product = $request->getAttribute('id');

        if(!is_numeric($id_product)){
            return $response->withRedirect(PATH.'/admin/product/errordelete');
        }
        $sql = "SELECT * FROM product WHERE id_product = ?";
        $product = $this->db->prepare($sql);
        $product->execute(array($id_product));

        if($product->rowCount() == 0){
            return $response->withRedirect(PATH.'/admin/product/errordelete');
        }

        $sql = "DELETE FROM product WHERE id_product = ?";
        $delete = $this->db->prepare($sql);
        $delete->execute(array($id_product));

        if($delete->rowCount() > 0){//deletou
            return $response->withRedirect(PATH.'/admin/product/successdelete');
        }else{//não deletou
            return $response->withRedirect(PATH.'/admin/product/errordelete');
        }

    }


    public function successdelete($request, $response){//se sucesso ao deletar, carrega a tela de produtos com mensagem de sucesso
        $vars['title'] = 'Lista de Produtos';
        $vars['page'] = 'product/list';
        $vars['del_success'] = "Produto excluído com sucesso!";
        $sql = "SELECT * FROM product ORDER BY id_product DESC";

        $products = $this->db->prepare($sql);
        $products->execute();

        if($products->rowCount() > 0){
            $vars['products'] = $products->fetchAll(\PDO::FETCH_OBJ);
        }else{// se vazio
            $vars['empty'] = "Nenhum produto cadastrado!";
        }

        return $this->view->render($response,'admin/template.phtml',$vars);
    }

    public function errordelete($request, $response){//se erro ao deletar, carrega a tela de produtos com mensagem de erro
        $vars['title'] = 'Lista de Produtos';
        $vars['page'] = 'product/list';
        $vars['del_error'] = "Erro ao excluir produto, tente mais tarde!";
        $sql = "SELECT * FROM product ORDER BY id_product DESC";

        $products = $this->db->prepare($sql);
        $products->execute();

        if($products->rowCount() > 0){
            $vars['products'] = $products->fetchAll(\PDO::FETCH_OBJ);
        }

        return $this->view->render($response,'admin/template.phtml',$vars);
    }



}