<?php

declare(strict_types=1);

namespace App\Actions;

use App\ActionInterface;
use App\RequestAwareInterface;
use App\RequestAwareTrait;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use User\Entity\User;
use User\UserInterface;
use Webinertia\Utils\Debug;

final class LoginAction extends AbstractAction implements RequestAwareInterface
{
    use RequestAwareTrait;

    public function __construct(
        private UserInterface&User $user
    ) {
    }

    public function run(): ?ResponseInterface
    {
        $eventManager = $this->getEventManager();
        //$eventManager->addIdentifiers([static::class]);
        $result = $eventManager->trigger(ActionInterface::EVENT_LOGIN, $this, [
            'userData' => [
                'userName' => 'Tyrsson',
                'userId' => 1,
                'role' => 'Administrator'
            ],
            'userInstance' => $this->user,
        ]);
        $template = $this->getTemplate();
        $response = new HtmlResponse(
            $template->render('app:login')
            . Debug::dump(
                var: $this->user,
                label: 'User\Entity\User',
                echo: false
            )
        );
        return $response;
    }
}
