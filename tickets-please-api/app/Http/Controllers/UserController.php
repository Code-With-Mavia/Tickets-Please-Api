<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\ApiUserUpdateRequest;
use App\Traits\ApiResponses;
use App\Models\Tickets;

class UserController extends Controller
{
    use ApiResponses;
   public function index()
   {
        $users = User::select("id","name","email")->paginate(2000);
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
        $updatedData = $user->update($request->validated());
        return $this->ok($updatedData,'User updated successfully');

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

    public function ticketUserStats($id)
    {
        $stats = Tickets::where('user_id', $id)->select('status')->selectRaw('COUNT(*) AS TOTAL')->groupBy('status')->get();
        return $this->ok($stats);
    }

}
