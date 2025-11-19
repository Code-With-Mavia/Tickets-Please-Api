<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tickets;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\ApiUserUpdateRequest;
use App\Traits\ApiResponses;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $cacheKey = 'users_with_tickets_page_1';

        $users = Cache::remember($cacheKey, 60, function ()
        {
            return UserResource::collection(User::with('tickets')->paginate(50));
        });

        return $users;
    }

    public function updateUser(ApiUserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user)
        {
            return $this->error('Invalid user', 404);
        }

        $user->update($request->validated());
        return $this->ok(
            new UserResource($user),
            'User updated successfully'
        );
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user)
        {
            return $this->error('User not found', 404);
        }

        $deletedUser = $user->delete();
        return $this->ok($deletedUser, 'User deleted successfully');
    }

    public function ticketUserStats($id)
    {


        $stats = Tickets::where('user_id', $id)
                ->select('status')
                ->selectRaw('COUNT(*) AS TOTAL')
                ->groupBy('status')
                ->get();

        return $this->ok($stats);
    }

    public function getSingleUser($id)
    {
        // $cacheKey = "user_{$id}";

        // $user = Cache::remember($cacheKey, 60, function () use ($id)
        // {
        //     return User::with('tickets')->find($id);
        // });
        $user = User::with('tickets')->find($id);

        if (!$user)
        {
            return $this->error('User not found', 404);
        }

        return $this->ok(
            new UserResource($user),
            'User Data Fetched successfully'
        );
    }
}
