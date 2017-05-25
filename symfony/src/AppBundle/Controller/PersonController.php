<?php

namespace AppBundle\Controller;

use AppBundle\Document\Person;
use Doctrine\ODM\MongoDB\DocumentManager;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class PersonController extends Controller
{
    /**
     * @Route("/person")
     * @Method("GET")
     */
    public function readAction()
    {
        //$userService = $this->get('user_service');
        //$persons = $userService->readAll();

        $persons = $this->get('person_repository')->findAll();

        if ($persons === null) {
            return new Response("there are no persons exist", Response::HTTP_NOT_FOUND);
        }

        /** @var Serializer $serializer */
        $serializer = $this->get('jms_serializer');
        return new Response($serializer->serialize($persons, 'json'), Response::HTTP_OK);
    }

    /**
     * @Route("/person")
     * @Method("POST")
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $phone = $request->get('phone');

        if (empty($firstName) || empty($lastName) || empty($phone)) {
            return new Response("null values are not allowed", Response::HTTP_NOT_ACCEPTABLE);
        }

        $newPerson = new Person();
        $newPerson->setFirstName($firstName);
        $newPerson->setLastName($lastName);
        $newPerson->setPhone($phone);

        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($newPerson);
        $dm->flush();

        return new Response("user added successfully", Response::HTTP_OK);
    }

    /**
     * @Route("/person/{id}")
     * @Method("PUT")
     *
     * @param string $id Person id
     * @param Request $request
     * @return Response
     */
    public function updateAction($id, Request $request)
    {
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $phone = $request->get('phone');
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var Person $person */
        $person = $this->get('person_repository')->find($id);

        if (empty($person)) {
            return new Response("person not found", Response::HTTP_NOT_FOUND);
        }

        if (!empty($firstName)) {
            $person->setFirstName($firstName);
        }
        if (!empty($lastName)) {
            $person->setLastName($lastName);
        }
        if (!empty($phone)) {
            $person->setPhone($phone);
        }

        $dm->persist($person);
        $dm->flush();

        return new Response("person #$id updated successfully", Response::HTTP_OK);
    }

    /**
     * @Route("/person/{id}")
     * @Method("DELETE")
     *
     * @param string $id Person id
     * @param Request $request
     * @return Response
     */
    public function deleteAction($id, Request $request)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var Person $person */
        $person = $this->get('person_repository')->find($id);

        if (empty($person)) {
            return new Response("person not found", Response::HTTP_NOT_FOUND);
        }

        $dm->remove($person);
        $dm->flush();

        return new Response("person #$id removed successfully", Response::HTTP_OK);
    }

    /**
     * @Route("/person")
     * @Method("DELETE")
     *
     * @param Request $request
     * @return Response
     */
    public function deleteAllAction(Request $request)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->createQueryBuilder('AppBundle\Document\Person')
            ->remove()
            ->getQuery()
            ->execute();

        return new Response("all persons removed successfully", Response::HTTP_OK);
    }
}
