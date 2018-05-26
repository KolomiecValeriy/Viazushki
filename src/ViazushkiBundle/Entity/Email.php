<?php

namespace ViazushkiBundle\Entity;

use Symfony\Component\Validator\Constraints;

class Email
{
    /**
     * @var string
     *
     * @Constraints\NotBlank(message="Email не может быть пустым")
     * @Constraints\Email(message="Вы допустили ошибку в email адрессе")
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
}
