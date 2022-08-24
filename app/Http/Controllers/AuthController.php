<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domain\User\UserManager;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegistrationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private UserManager $manager;

    public function __construct(UserManager $userManager)
    {
        $this->manager = $userManager;
    }

    public function register(RegistrationRequest $request): JsonResponse
    {
        $response = $this->manager->store($request->getInputData());
        return response()->json($response->toArray(), 201);
    }

    public function logIn(LoginRequest $request): JsonResponse
    {
        $user = $this->manager->getUser($request->input('email'));

        if (!$user || !Hash::check($request->input('password'), $user->getAttribute('password'))) {
            return response()->json(['message' => 'Wrong credentials'], 401);
        }

        $token = $this->manager->getNewToken($user);

        return response()->json([
            'token' => $token->plainTextToken,
            'expires_at' => $token->accessToken->getAttribute('expires_at')
        ], 201);
    }

    public function logOut(Request $request): JsonResponse
    {
        if (auth()->check()) {
            $this->manager->terminateAccess($request->user());
        }

        return response()->json('Logged out');
    }
}
