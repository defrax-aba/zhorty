<?php

namespace Zhorty\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\HydratorInterface as Hydrator;

class Trim extends AbstractTableGateway
{
    private $entityHydrator; 
    private $entity;
    
    public function setDbAdapter(Adapter $adapter) {
        $this->adapter = $adapter;
    }
    
    public function setTableName($table) {
        $this->table = $table;
    }
    
    public function setEntityHydrator(Hydrator $entityHydrator)
    {
        $this->entityHydrator = $entityHydrator;
    }
    
    public function save(\Zhorty\Entity\Trim $entity) {
        $this->entity = $entity;
        $set = $this->entityHydrator->extract($entity);
        return parent::insert($set);
    }

	public function setResultSetPrototype(\Zhorty\Entity\Trim $entity) {
        if (!$this->entityHydrator) {
            throw new \Exception('Hydrator for entity is not set');
        }
        $this->entity = $entity;
        $this->resultSetPrototype = new HydratingResultSet(
        	$this->entityHydrator,
            $entity
		);
    }
    
	public function fetchAll()
    {
        $resultSet = $this->select();
        return $resultSet;
    }
    
    public function getOrigUriByTrimPath($trimPath) 
    {
        $rowset = $this->select(array(
            'trim_path' => $trimPath,
        ));

        $entity = $rowset->current();

        if (!$entity) {
            throw new \Exception("Could not find row for trim path [$trimPath]");
        }

        return $entity->getOrigUrl();
    }
}