<?php

namespace App\Action;

use App\DTO\ContactDTO;
use App\Repository\ContactRepository;
use App\Serializer\ContactDTONormalizer;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateContact
{
    /** @var SerializerInterface $serializer */
    private $serializer;

    /** @var ValidatorInterface $validator */
    private $validator;

    /** @var ContactDTONormalizer $contactDTONormalizer */
    private $contactDTONormalizer;

    /** @var ContactRepository $repository */
    private $repository;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        ContactDTONormalizer $contactDTONormalizer,
        ContactRepository $repository
    )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->contactDTONormalizer = $contactDTONormalizer;
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        //get data from request
        $payload = $request->getContent();
//
//        var_dump($payload);
//        exit;

        if(!$payload){
            return new Response(null, Response::HTTP_BAD_REQUEST); //todo - test
        }

        //convert to dto
        try{
            $dto = $this->serializer->deserialize($payload, ContactDTO::class, 'json');
        }catch (Exception $e){
            return new Response('Deserialization error', Response::HTTP_BAD_REQUEST);
        }

        //validate dto
        /** @var ConstraintViolationList $errors */
        $errors = $this->validator->validate($dto);

        if($errors->count() > 0){
            $response = [];
            foreach ($errors->getIterator() as $error)
            {
                $response[$error->getPropertyPath()] = $error->getMessage();
            }
            return new Response(json_encode($response), Response::HTTP_BAD_REQUEST); //todo - move this to trait - test
        }

        //convert to entity
        $entity = $this->contactDTONormalizer->denormalize($dto); //todo - test

        //save to db
        try{
            $this->repository->save($entity);
        }catch (Exception $exception){
            return new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response($this->serializer->serialize($entity, 'json'), Response::HTTP_CREATED);
    }
}