<?php

namespace App\UI\API;

use App\Application\Admin\AddUserCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/api/register", name="api_register")
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        try {
        $data = (json_decode($request->getContent(), true));
        $username = $data['_username'];
        $password = $data['_password'];
        $command = new AddUserCommand($username, $password);

            $this->commandBus->handle($command);
        } catch (\Exception $e) {
            return $this->json([
               'message' => $e->getMessage()
            ]);
        }
        return $this->json([
            'message' => sprintf('User %s successfully created', $username),
        ]);
    }
}
