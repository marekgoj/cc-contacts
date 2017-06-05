<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Address
 *
 * @ODM\Document(
 *      collection="address",
 *      repositoryClass="AppBundle\Repository\AddressRepository"
 * )
 */
class Address
{
    const TYPE_HOME = 'home';
    const TYPE_BILLING = 'billing';
    const TYPE_SHIPPING = 'shipping';

    /**
     * @var string
     * @ODM\Id(strategy="ALNUM")
     */
    protected $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $address;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $city;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    protected $type;

    public function getId()
    {
        return $this->id;
    }


    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $type One of allowed types.
     */
    public function setType($type)
    {
        if (!in_array($type, [self::TYPE_HOME, self::TYPE_BILLING, self::TYPE_SHIPPING])) {
            throw new \InvalidArgumentException('Given address type is invalid.');
        }
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $address
     * @return Address
     */
    public static function createFromArray(array $address)
    {
        $newAddress = new self();
        if (isset($address['address'])) {
            $newAddress->setAddress($address['address']);
        }
        if (isset($address['city'])) {
            $newAddress->setCity($address['city']);
        }
        if (isset($address['type'])) {
            $newAddress->setType($address['type']);
        }
        return $newAddress;
    }
}
