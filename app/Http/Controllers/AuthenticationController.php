<?php

namespace App\Http\Controllers;


use App\Entities\Repositories\UserMetadataRepo;
use App\Entities\Repositories\UserRepo;
use App\Http\Requests\AuthRequest;
use App\Http\Traits\JsonResponseTrait;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class AuthenticationController
 *
 * @package App\Http\Controllers
 */
class AuthenticationController extends Controller
{
    use JsonResponseTrait;

    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     *  Register new user
     *  work flow:
     *  - validate fields while getting the request
     *  - get all fields
     *  - prepare default response object
     *  - create new user
     *  - create new user metadata
     *  - if everything saved correctly apologia user
     *  - else return error result to the user.
     *
     * @param AuthRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRequest $request)
    {
        $params        = $request->all();
        $json_response = $this->handleResponse([
            "status"   => 'error',
            "method"   => 'register',
            "username" => $params['username']
        ]);

        $saved_user     = (new UserRepo())->store($params);
        $saved_metadata = (new UserMetadataRepo())->storeMetadata($saved_user, $params);

        if ($saved_metadata && $saved_user) {
            $json_response = $this->handleResponse([
                "status"   => 'success',
                "method"   => 'register',
                "username" => $params['username']
            ]);
        }

        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json($json_response, $json_response['status']);
    }

    /**
     *  login user
     *  work flow:
     *  - get required field from request
     *  - try to create new token
     *  - return the results to the user
     *
     * @param AuthRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $jwt_token     = null;
        $input         = $request->only('username', 'password');
        $json_response = $this->handleResponse([
            "status" => 'error',
            "method" => 'login'
        ]);

        $jwt_token = JWTAuth::attempt($input);

        if ($jwt_token) {
            $json_response = $this->handleResponse([
                "status" => 'success',
                "method" => 'login'
            ], ['token' => $jwt_token]);
        }

        return response()->json($json_response, $json_response['status']);
    }

    /**
     *  Logout from the system
     *  work flow:
     * - get the token from the request
     * - try to delete it
     * - return response to the user
     *
     * @param AuthRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(AuthRequest $request)
    {
        try {
            JWTAuth::invalidate($request->token);
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'logout']);

            return response()->json($json_response, $json_response['status']);

        } catch (JWTException $exception) {
            $json_response = $this->handleResponse(["status" => 'error', "method" => 'logout']);

            return response()->json($json_response, $json_response['status']);
        }
    }

    /**
     * @param AuthRequest $request
     * Get logged user information according to his token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser(AuthRequest $request)
    {
        $json_response = $this->handleResponse(["status" => 'error', "method" => 'getAuthUser']);
        $user          = JWTAuth::authenticate($request->token);

        if ($user) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'getAuthUser'],
                ['user' => $user]);
        }

        return response()->json($json_response, $json_response['status']);
    }
}
