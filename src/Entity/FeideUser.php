<?php namespace IBok\OAuth2\Client\Entity;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class FeideUser implements ResourceOwnerInterface
{
    public $data;

    public function __construct(array $attributes)
    {
        $this->data = $attributes;
    }

    public function toArray()
    {
        return $this->data;
    }


    public function getId()
    {
        return $this->getField('id');
    }

    public function getFirstName(){
        return $this->getField("first_name");
    }

    public function getLastName(){
        return $this->getField("last_name");
    }

    public function getEmail(){
        return $this->getField("email");
    }


    private function getField($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}

