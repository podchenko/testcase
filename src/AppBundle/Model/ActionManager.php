<?php

namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;

class ActionManager
{
    /**
     * @var EntityManager
     */
    private  $_em;

    public function __construct($_em)
    {
        $this->_em = $_em;
    }

    public function getActions()
    {
        return $this->_em->getRepository('AppBundle:Action')->findAll();
    }

}