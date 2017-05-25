<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Person
 *
 * @ODM\Document(
 *      collection="person",
 *      repositoryClass="AppBundle\Repository\PersonRepository"
 * )
 */
class Person
{
    /**
     * @var string
     * @ODM\Id(strategy="ALNUM")
     */
    protected $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $first_name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $last_name;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $phone;


    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}
