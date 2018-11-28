<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = false,
     *     mode="html5"
     * )
     * @Assert\Length(min="1", max="100")
     */
    public $email;

    /**
     * @var string
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = 1,
     *      max = 1000,
     *      minMessage = "Your message should have at least {{ limit }} character",
     *      maxMessage = "Your message cannot be longer than {{ limit }} characters"
     * )
     */
    public $message;
}