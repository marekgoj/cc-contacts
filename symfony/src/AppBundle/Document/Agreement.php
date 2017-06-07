<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class Agreement
 *
 * @ODM\Document(
 *      collection="agreement"
 * )
 */
class Agreement
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
    protected $number;

    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     */
    protected $date_of_signing;

    public function getId()
    {
        return $this->id;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setDateOfSigning($dateOfSigning)
    {
        $this->date_of_signing = $dateOfSigning;
    }

    public function getDateOfSigning()
    {
        return $this->date_of_signing;
    }

    /**
     * @param null/array $agreement
     * @return self
     */
    public static function createFromArray($agreement)
    {
        if (isset($agreement['number']) && isset($agreement['dateOfSigning'])) {
            $newAgreement = new self();
            $newAgreement->setNumber($agreement['number']);
            $newAgreement->setDateOfSigning($agreement['dateOfSigning']);
        } else {
            $newAgreement = null;
        }
        return $newAgreement;
    }
}
