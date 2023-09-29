<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['admin', 'auth']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->ajax()
            ? response()->json(User::notAdmin()->with('company')->get())
            : view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create', ['companies' => Company::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        User::create($request->validated());

        return response()->json(['message' => 'User Berhasil Ditambahkan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        if ($request->query('notif')) {
            Notification::where('id', $request->query('notif'))
                ->update(['is_read' => true]);
        }

        return view('users.edit', [
            'user' => $user,
            'companies' => Company::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['password'] = $data['password'] ?? $user->password;

        $user->update($data);

        return response()->json(['message' => 'User Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User Berhasil Dihapus']);
    }
}
