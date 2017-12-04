<?php

namespace ViazushkiBundle\Entity;

use Symfony\Component\Validator\Constraints;

class Contact
{
    /**
     * @var string
     *
     * @Constraints\NotBlank(message="Это поле не может быть пустым")
     */
    private $name;

    /**
     * @var string
     *
     * @Constraints\NotBlank(message="Это поле не может быть пустым")
     * @Constraints\Email(message="Вы допустили ошибку в email адрессе")
     */
    private $email;

    /**
     * @var string
     *
     * @Constraints\NotBlank(message="Необходимо ввести текст сообщения")
     * @Constraints\Length(min="10", minMessage="Текст сообщения должен быть не меньше 10-ти символов")
     */
    private $text;

    /**
     * @var string
     */
    private $date;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Contact
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return Contact
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }


}