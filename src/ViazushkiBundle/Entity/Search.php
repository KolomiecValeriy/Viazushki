<?php

namespace ViazushkiBundle\Entity;

use Symfony\Component\Validator\Constraints;

class Search
{
    /**
     * @var string
     *
     * @Constraints\NotBlank(message="Это поле не может быть пустым")
     * @Constraints\Length(min="4", minMessage="Минимальная длина строки поиска 4 символа")
     */
    private $searchText;

    /**
     * @return string
     */
    public function getSearchText()
    {
        return $this->searchText;
    }

    /**
     * @param string $searchText
     */
    public function setSearchText(string $searchText)
    {
        $this->searchText = $searchText;
    }
}
