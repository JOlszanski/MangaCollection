<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Genre
 *
 * @ORM\Table(name="genre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenreRepository")
 */
class Genre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Language", mappedBy="genres")
     */
    private $language;

    /**
     * @ORM\ManyToMany(targetEntity="Manga", mappedBy="genres")
     */
    private $mangas;

    /**
     * Genre constructor.
     */
    public function __construct()
    {
        $this->mangas = new ArrayCollection();
        $this->language = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Genre
     */
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getMangas()
    {
        return $this->mangas;
    }

    /**
     * @param mixed $mangas
     */
    public function setMangas($mangas)
    {
        $this->mangas = $mangas;
    }

    /**
     * @param Manga $manga
     */
    public function addManga(Manga $manga): void
    {
        $this->mangas[] = $manga;
    }

    /**
     * @param Language $language
     */
    public function addLanguage(Language $language): void
    {
        /** @var Language $language */
        $language->addGenre($this);
        $this->language[] = $language;
    }

}

