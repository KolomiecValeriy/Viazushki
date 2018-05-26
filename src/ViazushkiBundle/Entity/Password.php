<?php

namespace ViazushkiBundle\Entity;

use Symfony\Component\Validator\Constraints;

class Password
{
    private $password;

    /**
     * @Constraints\NotBlank(message="Password can not be empty!"))
     * @Constraints\Length(max="60", min="5", maxMessage="Пароль не должен превышать 60 символов", minMessage="Пероль должен быть больше 5-ти символов")
     */
    private $plainPassword;

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return Password
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return Password
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
