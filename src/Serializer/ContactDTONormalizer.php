<?php

namespace App\Serializer;

use App\DTO\ContactDTO;
use App\Entity\Contact;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ContactDTONormalizer implements NormalizerInterface
{

    /**
     * @param $dto
     * @return Contact
     */
    public function denormalize($dto): Contact
    {
        if(!$dto instanceof ContactDTO){
            throw new InvalidArgumentException();
        }

        $entity = new Contact();
        $entity->setEmail($dto->email);
        $entity->setMessage($dto->message);

        return $entity;
    }

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param mixed $object Object to normalize
     * @param string $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|int|float|bool
     *
     * @throws InvalidArgumentException   Occurs when the object given is not an attempted type for the normalizer
     * @throws CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws LogicException             Occurs when the normalizer is not called in an expected context
     */
    public function normalize($object, $format = null, array $context = array())
    {
        // TODO: Implement this when this app needs to retrieve contact from db
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ContactDTO;
    }
}