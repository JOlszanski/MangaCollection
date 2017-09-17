<?php
/**
 * Created by PhpStorm.
 * User: jolszanski
 * Date: 31.08.17
 * Time: 13:15
 */

namespace AppBundle\Voter;


use AppBundle\Entity\Manga;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class MangaVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * MangaVoter constructor.
     * @param $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {

        if(!in_array($attribute,array(self::EDIT,self::VIEW))){
            return false;
        }

        if(!$subject instanceof Manga){
           return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if(!$user instanceof User){
            return false;
        }

        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }


        /** @var Manga manga */
        $manga = $subject;
        switch ($attribute){
            case self::VIEW:
                return $this->canView($manga,$user);
            case self::EDIT:
                return $this->canEdit($manga,$user);
        }
    }

    private function canView(Manga $manga, User $user)
    {
        if($this->canEdit($manga,$user)){
            return true;
        }


    }

    private function canEdit(Manga $manga,User $user)
    {
        return $user === $manga->getOwner();
    }

}