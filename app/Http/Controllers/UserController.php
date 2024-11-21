<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('users');
    }

    public function getUsers()
    {

        $user = User::orderBy('id', 'desc')->get();
        return $user;
    }

    public function getUserId()
    {
        // Assuming you have some logic to fetch the user ID
        $userId = auth()->id(); // Example: Fetch user ID using Laravel's authentication
        
        if ($userId) {
            return response()->json(['userId' => $userId]);
        } else {
            return response()->json(['error' => 'User ID not found'], 404);
        }
    }

    public function getProfile()
    {
        return view('profile');
    }

    public function createUsers(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:20',
            'lastname' => 'required|string|max:20',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users',
            'phone' => 'required',
            'user_type' => 'required',
            'status' => 'required',
            'password' => 'required|string|min:6|confirmed|unique',
            'role' => ['required', 'string', 'in:user,admin'] // Validate role

        ]);
        $user = new User();


        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;
        $user->status = $request->status;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function updateUsers(Request $request, $id)
    {
        $this->validate($request, [
            'name',
            'lastname',
            'email',
            'phone',
            'user_type',
            'status',
            'password'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);

        $user->save();
    }

    public function deleteUsers($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
