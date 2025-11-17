<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\ApiUserUpdateRequest;
use App\Traits\ApiResponses;

class UserController extends Controller
{
    use ApiResponses;
   public function index()
   {
        $users = User::all();
        return $users;
   }

   //Updation
    public function updateUser(ApiUserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        if (!$user)
        {
            return $this->error('Invalid user', 401);
        }
        $updatedData = $user->update($request->validated());
        return $this->ok($updatedData,'User updated successfully');

    }

    //delete user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if (!$user)
        {
            return $this->error('User not found',404);
        }
        $deletedUser = $user->delete();
        return $this->ok($deletedUser,'User deleted successfully');
    }
}
