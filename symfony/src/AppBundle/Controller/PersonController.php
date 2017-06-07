<?php

namespace AppBundle\Controller;

use AppBundle\Document\Address;
use AppBundle\Document\AddressCollection;
use AppBundle\Document\Agreement;
use AppBundle\Document\Person;
use Doctrine\ODM\MongoDB\DocumentManager;
use JMS\Serializer\SerializationContext;
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
        $context = new SerializationContext();
        $context->setSerializeNull(true);
        return new Response($serializer->serialize($persons, 'json', $context), Response::HTTP_OK);
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
        $content = json_decode($request->getContent(), true);
        $firstName = isset($content['firstName']) ? $content['firstName'] : null;
        $lastName = isset($content['lastName']) ? $content['lastName'] : null;
        $phone = isset($content['phone']) ? $content['phone'] : null;
        $addresses = isset($content['addresses']) ? $content['addresses'] : [];
        $agreement = isset($content['agreement']) ? $content['agreement'] : null;

        if (empty($firstName) || empty($lastName)) {
            return new Response("person must have first and last name", Response::HTTP_NOT_ACCEPTABLE);
        }

        $newPerson = new Person();
        $newPerson->setFirstName($firstName);
        $newPerson->setLastName($lastName);
        $newPerson->setPhone($phone);

        $newAddresses = new AddressCollection();
        foreach($addresses as $address) {
            $newAddress = Address::createFromArray($address);
            $newAddresses->add($newAddress);
        }
        $newPerson->setAddresses($newAddresses);

        $newAgreement = Agreement::createFromArray($agreement);
        $newPerson->setAgreement($newAgreement);

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
        $content = json_decode($request->getContent(), true);

        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var Person $person */
        $person = $this->get('person_repository')->find($id);

        if (empty($person)) {
            return new Response("person not found", Response::HTTP_NOT_FOUND);
        }

        if (isset($content['firstName'])) {
            $person->setFirstName($content['firstName']);
        }
        if (isset($content['lastName'])) {
            $person->setLastName($content['lastName']);
        }
        if (array_key_exists('phone', $content)) {
            $person->setPhone($content['phone']);
        }
        if (array_key_exists('addresses', $content)) {
            $newAddresses = new AddressCollection();
            if (is_array($content['addresses'])) {
                foreach($content['addresses'] as $address) {
                    $newAddress = Address::createFromArray($address);
                    $newAddresses->add($newAddress);
                }
            }
            $person->setAddresses($newAddresses);
        }

        if (array_key_exists('agreement', $content)) {
            $newAgreement = Agreement::createFromArray($content['agreement']);
            $person->setAgreement($newAgreement);
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
