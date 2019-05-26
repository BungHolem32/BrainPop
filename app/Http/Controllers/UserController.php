<?php

namespace App\Http\Controllers;


use App\Entities\Models\User;
use App\Entities\Repositories\UserMetadataRepo;
use App\Entities\Repositories\UserRepo;
use App\Http\Requests\UserRequest;
use App\Http\Traits\JsonResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use JWTAuth;

/**
 * @property UserRepo         model_repo
 * @property UserMetadataRepo metadata_model_repo
 * @property  User            user
 * @property  integer         role_id
 * @property  array           fields
 */
class UserController extends Controller
{
    use JsonResponseTrait;

    protected $role_id;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->model_repo          = new UserRepo();
        $this->metadata_model_repo = (new UserMetadataRepo());
        $this->assignUser();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users         = $this->getUsersAndMetadataByRole($this->role_id);
        $json_response = $this->handleResponse(['status' => 'error', 'method' => 'index'], null);

        if (count($users)) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'index'], $users);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * Display the specified resource.
     *
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $request)
    {
        $user_id       = array_values($request->route()->parameters())[0];
        $json_response = $this->handleResponse(["status" => 'error', "method" => 'show', "id" => $user_id], null);
        $user          = $this->getUserByRoleId($user_id, $this->role_id);


        if (!empty($user) && $user->exists) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'show', "id" => $user->id],
                $user);
        }

        return response()->json($json_response, $json_response["status"]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $json_response = $this->handleResponse(["status" => 'error', "method" => 'store'], null);
        $saved_model   = $this->storeUser($request);

        if ($saved_model) {
            $json_response = $this->handleResponse([
                "status" => 'success',
                "method" => 'store',
                "id"     => $saved_model['id']
            ],
                $saved_model);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest    $request
     * @param                $id
     *
     * @return User
     */
    public function update(UserRequest $request, $id)
    {
        $updated_model = false;
        $json_response = $this->handleResponse(["status" => 'no_fields', "method" => 'update', "id" => $id], null);
        $params        = $request->only($this->fields);

        if (count($params)) {
            $json_response = $this->handleResponse(["status" => 'error', "method" => 'update', "id" => $id], null);
            $updated_model = $this->updateUser($request, $id);
        }

        if ($updated_model) {
            $json_response = $this->handleResponse([
                "status" => 'success',
                "method" => 'update',
                "id"     => $updated_model['id']
            ],
                $updated_model);
        }

        return response()->json($json_response, $json_response["status"]);
    }

    /**
     * Destroy  specific record from storage.
     * /**
     * Remove the specified resource from storage.
     *
     * @param UserRequest $request
     *
     * @return string
     */
    public function destroy(UserRequest $request)
    {
        $deleted       = false;
        $user_id       = array_values(($request->route()->parameters()))[0];
        $user          = $this->model_repo->find($user_id);
        $json_response = $this->handleResponse(["status" => 'error', "method" => 'destroy', "id" => $user->id],
            null);

        if ($user->role_id == $this->role_id && $user) {
            $deleted = $user->delete();
        }

        if ($deleted) {
            $json_response = $this->handleResponse(["status" => 'success', "method" => 'destroy', "id" => $user->id],
                $user);
        }

        return response()->json($json_response, $json_response["status"]);
    }


    /**
     * @param $request
     *
     * @return bool
     */
    public function storeUser($request)
    {
        $fields            = $request->all();
        $fields['role_id'] = $this->role_id;

        $saved_teacher = $this->model_repo->store($fields);

        if ($saved_teacher) {
            $saved_metadata = $this->metadata_model_repo->storeMetadata($saved_teacher, $fields);
        }

        $model                       = $saved_teacher->toArray();
        $model[$saved_metadata->key] = $saved_metadata->value;

        return $model;
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return bool
     */
    public function updateUser($request, $id)
    {
        $user = $this->model_repo->find($id);

        if (!$user->exists) {
            return false;
        }

        $fields_to_update = $this->prepareFields($request);

        $updated_user = $user->update($fields_to_update);

        if (!$updated_user) {
            return false;
        }
        $updated_metadata = $this->metadata_model_repo->updateMetadata($user, $fields_to_update);

        if (!$updated_metadata) {
            return false;
        }

        $updated_model                         = $user->toArray();
        $updated_model[$updated_metadata->key] = $updated_metadata->value;

        return $updated_model;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId($role_id): void
    {
        $this->role_id = $role_id;
    }

    /**
     * @param int $role_id
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getUsersAndMetadataByRole(int $role_id)
    {
        $users          = $this->model_repo->getByRoleId($role_id);
        $users_metadata = $this->metadata_model_repo->getByRoleId($role_id);

        $this->combineUserAndUserMetadata($users, $users_metadata);

        return $users;
    }

    /**
     * @param Collection $users
     * @param Collection $users_metadata
     */
    private function combineUserAndUserMetadata($users, $users_metadata)
    {
        $users_metadata = $users_metadata->keyBy('user_id');

        $users->transform(function ($user) use ($users_metadata) {
            $user_metadata               = $users_metadata[$user->id];
            $user->{$user_metadata->key} = $user_metadata->value;

            return $user;
        });
    }

    /**
     * @param $user_id
     * @param $role_id
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getUserByRoleId($user_id, $role_id)
    {
        $user_metadata = $this->metadata_model_repo->getRoleIdAndId($role_id, $user_id);
        $user          = $this->model_repo->getByRoleIdAndId($user_id, $role_id);

        if ($user_metadata && $user) {
            $user->{$user_metadata->key} = $user_metadata->value;
        }

        return $user;
    }

    private function prepareFields($request)
    {
        $fields_to_update = $request->all();

        if (!empty($fields_to_update['password'])) {
            $fields_to_update['password'] = bcrypt($fields_to_update['password']);
        }

        $fields_to_update['role_id'] = $this->role_id;

        return $fields_to_update;
    }

}
