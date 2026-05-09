<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->input('archive') == 'true') {
            $query = $query->onlyTrashed();
        }

        $data = $query->paginate(10)->onEachSide(1);

        return view('user.index', compact('data'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

     public function update(UpdateUserRequest $request, $id)
{
    $user = User::findOrFail($id);
    $user->update([
        'password' => bcrypt($request->password),
    ]);

    if ($request->redirect_to === 'index') {
        return redirect()->route('users.index')
                         ->with('success', 'Password updated successfully.');
    }

    return redirect()->route('users.index')
                     ->with('success', 'Password updated successfully.');
}
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User archived successfully.');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index', ['archive' => 'true'])
                         ->with('success', 'User restored successfully.');
    }
}