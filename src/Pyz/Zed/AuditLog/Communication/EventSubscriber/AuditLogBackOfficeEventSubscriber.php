<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\AuditLog\Communication\EventSubscriber;

use Generated\Shared\Transfer\AuditLogActorTransfer;
use Generated\Shared\Transfer\AuditLogTransfer;
use Pyz\Zed\AuditLog\AuditLogTrait;
use Pyz\Zed\AuditLog\Business\AuditLogFacadeInterface;
use Spryker\Zed\User\Business\UserFacadeInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Contracts\EventDispatcher\Event;

class AuditLogBackOfficeEventSubscriber implements EventSubscriberInterface
{
    use AuditLogTrait;

    protected UserFacadeInterface $userFacade;

    public function __construct(
        UserFacadeInterface $userFacade
    ) {
        $this->userFacade = $userFacade;
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $this->setCurrentUser($event);

        $this->getAuditLogger()->collectAuditLogData(
            (new AuditLogTransfer())
                ->setAction('loginSuccess')
                ->setTimestamp(time()),
        );
    }

    public function onControllerEvent(ControllerEvent $event): void
    {
        $this->setCurrentUser($event);
    }

    public function onLogout(LogoutEvent $event): void
    {
        $this->setCurrentUser($event);

        $this->getAuditLogger()->collectAuditLogData(
            (new AuditLogTransfer())
                ->setAction('onLogout')
                ->setTimestamp(time()),
        );
    }

    public function onLoginFailure(LoginFailureEvent $event): void
    {
        $badAuth = $event->getRequest()->request->all('auth');

        $this->getAuditLogger()->collectAuditLogData(
            (new AuditLogTransfer())
                ->setAction('onLoginFailure')
                ->setTimestamp(time())
                ->setDetails(json_encode(['badAuth' => $badAuth]))
        );
    }

    protected function setCurrentUser(Event $event): void
    {
        if (!$this->userFacade->hasCurrentUser()) {
            return;
        }

        $currentUser = $this->userFacade->getCurrentUser();

        $this->getAuditLogger()->setAuditLogActor((new AuditLogActorTransfer())
            ->setType('User')
            ->setIdentifier((string) $currentUser->getIdUser())
            ->setDetails(json_encode(['clientIp' => $event->getRequest()->getClientIp()]))
        );
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
            KernelEvents::CONTROLLER => 'onControllerEvent',
            LogoutEvent::class => 'onLogout',
            LoginFailureEvent::class => 'onLoginFailure',
        ];
    }
}
