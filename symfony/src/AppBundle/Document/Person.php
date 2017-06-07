<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

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

    /**
     * @var AddressCollection
     * @Type("ArrayCollection<AppBundle\Document\Address>")
     * @ODM\ReferenceMany(
     *     collectionClass="AppBundle\Document\AddressCollection",
     *     targetDocument="AppBundle\Document\Address",
     *     cascade="all",
     *     orphanRemoval=true
     * )
     */
    protected $addresses;

    /**
     * @var Agreement
     * @ODM\ReferenceOne(
     *     targetDocument="AppBundle\Document\Agreement",
     *     cascade="all",
     *     orphanRemoval=true
     * )
     */
    protected $agreement;

    public function __construct()
    {
        $this->addresses = new AddressCollection([]);
    }

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

    public function setAddresses(AddressCollection $addresses)
    {
        $this->addresses = $addresses;
    }

    public function getAddresses()
    {
        return $this->addresses;
    }

    public function setAgreement($agreement)
    {
        $this->agreement = $agreement;
    }

    public function getAgreement()
    {
        return $this->agreement;
    }
}
