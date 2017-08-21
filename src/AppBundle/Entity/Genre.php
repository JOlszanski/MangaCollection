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
     * @ORM\Column(name="genre", type="string", length=255)
     */
    private $genre;
    /**
     * var string
     *
     * ORM\Column(name="genre", type="string", length=255)
     * @ORM\ManyToMany(targetEntity="Manga", mappedBy="genre")
     */
    private $manga;

    /**
     * Genre constructor.
     */
    public function __construct()
    {
        $this->manga = new ArrayCollection();
    }

    public function __toString() {
        return $this->genre;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return Genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getManga()
    {
        return $this->manga;
    }

    /**
     * @param mixed $manga
     */
    public function setManga($manga)
    {
        $this->manga = $manga;
    }
}

