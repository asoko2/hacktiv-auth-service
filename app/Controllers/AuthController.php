<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BlacklistedTokens;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Validation\ValidationRules;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        helper('cookie');
    }

    public function login()
    {
        // $input = $this->request->getJSON();

        // $userModel = new \App\Models\UserModel();
        // $userData = $userModel->where('nip', $input->nip)->first();

        // if (!$userData) {
        //     return $this->response->setJSON([
        //         'status' => ResponseInterface::HTTP_NOT_FOUND,
        //         'message' => 'Invalid Credential'
        //     ]);
        // }

        // if (!password_verify($input->password, $userData->password)) {
        //     return $this->response->setJSON([
        //         'status' => ResponseInterface::HTTP_UNAUTHORIZED,
        //         'message' => 'Credential not match'
        //     ]);
        // }

        // $key = env('JWT_SECRET');
        // $payload = [
        //     'nip' => $userData->nip,
        //     'name' => $userData->username,
        //     'email' => $userData['email'],
        //     'iat' => time(),
        //     'exp' => time() + 60 * 60 * 6
        // ];

        // $token = JWT::encode($payload, $key, 'HS256');

        // set_cookie(
        //     name: 'access_token',
        //     value: $token,
        //     expire: 60 * 60 * 6,
        //     httpOnly: true,
        // );

        // return $this->response->setJSON([
        //     'status' => ResponseInterface::HTTP_OK,
        //     'message' => 'Login success',
        //     'data' => [
        //         'access_token' => $token
        //     ]
        // ]);


        //Codeigniter Shield JWT Auth
        $rules = new ValidationRules();
        $loginRules = $rules->getLoginRules();

        log_message('debug', 'Validate Data');
        if (!$this->validateData($this->request->getJSON(true), $loginRules,)) {
            return $this->fail($this->validator->getErrors());
        }

        // Get credentials for login
        log_message('debug', 'Get credentials');
        $credentials = $this->request->getJSONVar(setting('Auth.validFields'));
        $credentials = array_filter($credentials);
        $credentials['password'] = $this->request->getJsonVar('password');

        $authenticator = auth('session')->getAuthenticator();

        log_message('debug', 'Check credentials');
        $result = $authenticator->check($credentials);

        if (!$result->isOK()) {
            return $this->failUnauthorized($result->reason());
        }

        log_message('debug', 'Get user');
        $user = $result->extraInfo();

        $manager = service('jwtmanager');

        $jwtPayload = [
            'iat' => time(),
            'exp' => time() + 60 * 60 * 6
        ];

        $token = $manager->generateToken($user, $jwtPayload);

        return $this->respond([
            'status' => ResponseInterface::HTTP_OK,
            'message' => 'Login success',
            'data' => [
                'access_token' => $token
            ]
        ]);
    }

    public function getProfile()
    {
        $user = auth()->user();

        return $this->respond([
            'status' => ResponseInterface::HTTP_OK,
            'data' => $user
        ]);
    }

    public function logout()
    {
        $blacklistModel = new BlacklistedTokens();
        
        $blacklistModel->save([
            'user_id' => auth()->id(),
            'token' => auth()->getTokenFromRequest($this->request)
        ]);

        return $this->respond([
            'message' => 'Logout successful.',
            'logout' => auth('jwt')->logout()
        ]);
    }
}
