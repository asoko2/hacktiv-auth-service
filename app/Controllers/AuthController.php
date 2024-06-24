<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    public function __construct()
    {
        helper('cookie');
    }
    
    public function login()
    {
        $input = $this->request->getJSON();

        $userModel = new \App\Models\UserModel();
        $userData = $userModel->where('nip', $input->nip)->first();

        if (!$userData) {
            return $this->response->setJSON([
                'status' => ResponseInterface::HTTP_NOT_FOUND,
                'message' => 'Invalid Credential'
            ]);
        }

        if (!password_verify($input->password, $userData['password'])) {
            return $this->response->setJSON([
                'status' => ResponseInterface::HTTP_UNAUTHORIZED,
                'message' => 'Credential not match'
            ]);
        }

        $key = env('JWT_TOKEN');
        $payload = [
            'nip' => $userData['nip'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'iat' => time(),
            'exp' => time() + 60 * 60 * 6
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        set_cookie(
            name: 'access_token',
            value: $token,
            expire: 60 * 60 * 6,
            httpOnly: true,
        );

        return $this->response->setJSON([
            'status' => ResponseInterface::HTTP_OK,
            'message' => 'Login success',
            'data' => [
                'access_token' => $token
            ]
        ]);
    }
}
