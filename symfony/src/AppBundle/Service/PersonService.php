<?php

namespace AppBundle\Service;

use Doctrine\Common\Persistence\ObjectRepository;

class PersonService implements IPersonService
{
    /** @var  ObjectRepository */
    protected $repository;

    /**
     * @param $personRepository
     * @return PersonService Created service
     */
    public static function createPersonService($personRepository)
    {
        return new self($personRepository);
    }

    public function __construct($personRepository)
    {
        $this->repository = $personRepository;
    }

    public function readAll()
    {
        return $this->repository->findAll();
    }
}
