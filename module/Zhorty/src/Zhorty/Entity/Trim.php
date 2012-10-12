<?php
namespace Zhorty\Entity;

class Trim
{
    private $id;
    private $origUrl;
    private $trimPath;

    public function getId ()
    {
        return $this->id;
    }
    
 	public function getOrigUrl ()
    {
        return $this->origUrl;
    }

    public function getTrimPath ()
    {
        return $this->trimPath;
    }

	public function setId ($id)
    {
        $this->id = $id;
        return $this;
    }
    
	public function setOrigUrl ($origUrl)
    {
        $this->origUrl = $origUrl;
        return $this;
    }

	public function setTrimPath ($trimPath)
    {
        $this->trimPath = $trimPath;
        return $this;
    }
}