<?php
namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class PaginationService{
    private $entityClass;
    private $limit=10;
    private $pageactuelle=1;
    private $manager;

    public function __construct(ObjectManager $manager){
        $this->manager=$manager;
    }

    public function getPages(){
        $repo=$this->manager->getRepository($this->entityClass);
        $total=count($repo->findAll());
        $pages=ceil($total/$this->limit);
        return $pages;

    }
    public function getData(){
        $position=$this->limit*($this->pageactuelle-1);
        $repo=$this->manager->getRepository($this->entityClass);
        $data=$repo->findBy([],[],$this->limit,$position);
        return $data;

    }

    public function setPageactuelle($pageactuelle){
        $this->pageactuelle=$pageactuelle;
        return $this;
    }
    public function getPageactuelle(){
        return $this->pageactuelle;
    }
    public function setLimit($limit){
        $this->limit=$limit;
        return $this;
    }
    public function getLimit(){
        return $this->limit;
    }

    public function setEntityClass($entityClass){
        $this->entityClass=$entityClass;
        return $this;
    }
    public function getEntityClass(){
        return $this->entityClass;
    }
}
?>