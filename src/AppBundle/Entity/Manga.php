<?php

namespace AppBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Manga
 *
 * @ORM\Table(name="manga")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MangaRepository")
 */
class Manga
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="jp_title", type="string", length=255)
     */
    private $jpTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="publisher", type="string", length=255)
     */
    private $publisher;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * var string
     *
     * ORM\Column(name="genre", type="string", length=255)
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="manga")
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=255)
     */
    private $cover;

    /**
     * @ORM\OneToMany(targetEntity="Volume",mappedBy="manga")
     */
    private $volumes;

    /**
     * Manga constructor.
     */
    public function __construct()
    {

        $this->genre = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Manga
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set jpTitle
     *
     * @param string $jpTitle
     *
     * @return Manga
     */
    public function setJpTitle($jpTitle)
    {
        $this->jpTitle = $jpTitle;

        return $this;
    }

    /**
     * Get jpTitle
     *
     * @return string
     */
    public function getJpTitle()
    {
        return $this->jpTitle;
    }

    /**
     * Set publisher
     *
     * @param string $publisher
     *
     * @return Manga
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Manga
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Manga
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set genre
     *
     * @param string $genre
     *
     * @return Manga
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
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return int
     */
    public function getVolumes()
    {
        return $this->volumes;
    }

    /**
     * @param int $volumes
     */
    public function setVolumes($volumes)
    {
        $this->volumes = $volumes;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

}