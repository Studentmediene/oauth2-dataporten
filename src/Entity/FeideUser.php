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


    public function getName()
    {
        return $this->getField("name");
    }

    public function getId()
    {
        return $this->getField('userid');
    }

    /**
     * @deprecated Not used by feide, Use getName()
     */
    public function getFirstName()
    {
        $name = $this->getName();
        return $name;
    }

    /**
     * @deprecated Not used by feide, Use getName()
     */
    public function getLastName()
    {
        $name = $this->getName();
        return $name;
    }

    public function getEmail()
    {
        return $this->getField("email");
    }

    public function getPictureUrl(){
        $img_domain = "https://api.dataporten.no/userinfo/v1/user/media/";
        $img_id = $this->getField("profilephoto");

        return $img_domain.$img_id;
    }

    private function getField($key)
    {
        return isset($this->data['user'][$key]) ? $this->data['user'][$key] : null;
    }
}

