<?php
namespace Package\R3m\Io\Boot\Trait;

trait Init {

    public function installation (){
        $object = $this->object();
        ddd($object->config('framework.environment'));
    }
}