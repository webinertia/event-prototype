<?php

declare(strict_types=1);

namespace App\Actions;

use App\ActionInterface;
use App\AppEvent;
use App\RequestAwareInterface;
use App\RequestAwareTrait;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Template\TemplateModel;
use User\Entity\User;
use User\UserInterface;
use Webinertia\Utils\Debug;

final class LoginAction extends AbstractAction
{
    public function __construct(
        private UserInterface&User $user
    ) {
    }

    public function onDispatch(AppEvent $e)
    {
        // todo: pick it up here
        // $request = $e->getRequest();
        // $eventManager = $this->getEventManager();
        // //$eventManager->addIdentifiers([static::class]);
        // $result = $eventManager->trigger(ActionInterface::EVENT_LOGIN, $this, [
        //     'userData' => [
        //         'userName' => 'Tyrsson',
        //         'userId' => 1,
        //         'role' => 'Administrator'
        //     ],
        //     'userInstance' => $this->user,
        // ]);
        // $template = $this->getTemplate();

        // $response = new HtmlResponse(
        //     $template->render('app:login')
        //     . Debug::dump(
        //         var: $this->user,
        //         label: 'User\Entity\User',
        //         echo: false
        //     )
        //     . Debug::dump(
        //         var: $request,
        //         label: $request::class,
        //         echo: false
        //     )
        // );

    }

    public function login(?string $subAction = null)
    {
        $model = new TemplateModel(); // return this for the moment to see if dispatch continues
        $model->setTemplate('app:login');
        return $model;
    }

    protected function loginTwo(TemplateModel $template)
    {
        $event = $this->getEvent();
        $subTemplate = new TemplateModel();
        $subTemplate->setTemplate('app:login-two');
        $subTemplate->setVariables();
    }
}
