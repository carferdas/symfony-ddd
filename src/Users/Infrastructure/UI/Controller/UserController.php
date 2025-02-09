<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\UI\Controller;

use App\Shared\Infrastructure\Symfony\WebController;
use App\Users\Application\Create\CreateUserCommand;
use App\Users\Application\Delete\DeleteUserCommand;
use App\Users\Application\Edit\UpdateUserCommand;
use App\Users\Application\Find\FindUserQuery;
use App\Users\Application\Find\ResponseFindUser;
use App\Users\Application\List\ListUsersQuery;
use App\Users\Application\List\ResponseListUsers;
use App\Users\Infrastructure\UI\Form\UserFormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends WebController
{
    #[Route('/users', name: 'users', methods: ['GET'])]
    public function index(): Response
    {
        /** @var ResponseListUsers $users */
        $users = $this->ask(new ListUsersQuery(10));

        return $this->render('pages/users/index.html.twig', [
            'users' => $users->users,
        ]);
    }

    #[Route('/users/create', name: 'users_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $form = $this->createForm(UserFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $this->dispatch(new CreateUserCommand(
                $data['firstName'],
                $data['lastName'],
                $data['email'],
                $data['password'],
                $data['isActive']
            ));

            return $this->redirectToRoute('users');
        }

        return $this->render('pages/users/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/users/{id}/edit', name: 'users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request): Response
    {
        /** @var ResponseFindUser $response */
        $response = $this->ask(new FindUserQuery($request->attributes->get('id')));

        $form = $this->createForm(UserFormType::class, [
            'firstName' => $response->user()->getFirstName(),
            'lastName' => $response->user()->getLastName(),
            'email' => $response->user()->getEmail(),
            'password' => $response->user()->getPassword(),
            'isActive' => $response->user()->isActive(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->dispatch(new UpdateUserCommand(
                $response->user()->getId(),
                $data['firstName'],
                $data['lastName'],
                $data['email'],
                $data['password'],
                $data['isActive']
            ));

            return $this->redirectToRoute('users');
        }

        return $this->render('pages/users/edit.html.twig', [
            'user' => $response->user(),
            'form' => $form,
        ]);
    }

    #[Route('/users/{id}/delete', name: 'users_delete', methods: ['DELETE'])]
    public function delete(Request $request): RedirectResponse
    {
        $this->dispatch(new DeleteUserCommand($request->attributes->get('id')));

        return $this->redirectToRoute('users');
    }
}
