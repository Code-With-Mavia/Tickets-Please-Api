<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\ApiUserUpdateRequest;
use App\Traits\ApiResponses;
use App\Models\Tickets;
use App\Http\Resources\UserResource;
class UserController extends Controller
{
    use ApiResponses;
   public function index()
   {
        $users = UserResource::collection(User::select("id","name","email","created_at","updated_at")->paginate(2000));
        return $users;
   }

   //Updation
    public function updateUser(ApiUserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user)
        {
            return $this->error('Invalid user', 404);
        }
        $user->update($request->validated());
        return $this->ok(new UserResource($user),'User updated successfully');

    }

    //delete user
    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user)
        {
            return $this->error('User not found',404);
        }
        $deletedUser = $user->delete();
        return $this->ok($deletedUser,'User deleted successfully');
    }

    //user stats of total tickets he has
    public function ticketUserStats($id)
    {
        $stats = Tickets::where('user_id', $id)->select('status')->selectRaw('COUNT(*) AS TOTAL')->groupBy('status')->get();
        return $this->ok($stats);
    }

    //get usersinfo by id
    public function getSingleUser($id)
    {
        $user = User::find($id);
        if (!$user)
        {
            return $this->error('User not found',404);
        }
        return $this->ok(new UserResource($user),'User Data Fetched sucessfully');
    }

}
