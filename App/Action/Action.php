<?php
/**
 * Created by PhpStorm.
 * User: Christian Reis
 * Date: 14/06/2018
 * Time: 16:07
 */

namespace App\Action;

class Action{
    private $container;

    function __construct($container){
        $this->container = $container;
    }

    public function __get($property){
        if($this->container->{$property}){
            return $this->container->{$property};
        }
    }

}