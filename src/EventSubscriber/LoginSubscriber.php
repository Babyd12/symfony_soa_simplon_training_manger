<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use \Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;
    private Security $security;

    public function __construct(UrlGeneratorInterface $urlGenerator,  Security $security)
    {
        $this->urlGenerator = $urlGenerator;
        $this->security = $security;
    }

    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $user = $this->security->getUser();

        if ($user instanceof User) 
        {
            if ($user->isAdmin()) {
                $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_formation_index')));
            } else {
                $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_home')));
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}
