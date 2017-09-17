<?php

// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *
     * @ORM\Column(name="nickname", type="string", length=255)
     */
    protected $nickname;

    /**
     * @ORM\OneToMany(targetEntity="Manga", mappedBy="user")
     */
    private $mangas;



    public function __construct()
    {
        parent::__construct();
        $this->mangas = new ArrayCollection();
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
    public function addManga(Manga $manga)
    {
        $this->mangas[] = $manga;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }


}
