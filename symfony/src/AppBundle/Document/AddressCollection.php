<?php

namespace AppBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;

class AddressCollection extends ArrayCollection
{
    /**
     * {@inheritDoc}
     */
    public function add($element)
    {
        if (! $element instanceof Address) {
            throw new \InvalidArgumentException('Only Address are allowed.');
        }

        $this->removeAllWithType($element->getType());

        return parent::add($element);
    }

    /**
     * @param string $type Address type
     */
    protected function removeAllWithType($type)
    {
        $sameType = $this->filter(function ($address) use ($type) {
            return $address->getType() === $type;
        });

        foreach ($sameType as $foundAddress) {
            $this->removeElement($foundAddress);
        }
    }
}
