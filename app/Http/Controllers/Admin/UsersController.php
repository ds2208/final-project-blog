<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UsersController extends Controller {

    public function index() {

        return view('admin.users.index', [
        ]);
    }

    public function datatable(Request $request) {

        $searchFilters = $request->validate([
            'status' => ['nullable', 'in:0,1'],
            'email' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
        ]);

        $query = User::query();

        $dataTable = \DataTables::of($query);
        $dataTable->addColumn('actions', function ($user) {
                    return view('admin.users.partials.actions', ['user' => $user]);
                })
                ->editColumn('photo', function ($user) {
                    return view('admin.users.partials.user_photo', ['user' => $user]);
                })
                ->editColumn('status', function ($user) {
                    return view('admin.users.partials.status', ['user' => $user]);
                })
                ->editColumn('id', function ($user) {
                    return '#' . $user->id;
                })
                ->editColumn('name', function ($user) {
                    return '<strong>' . e($user->name) . '</strong>';
                });

        $dataTable->rawColumns(['name', 'photo', 'actions']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            if ($request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])) {
                $searchTerm = $request->get('search')['value'];

                $query->where(function ($query) use ($searchTerm) {

                    $query->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.phone', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.id', '=', $searchTerm);
                });
            }

            if (isset($searchFilters['status'])) {
                $query->where('users.status', '=', $searchFilters['status']);
            }

            if (isset($searchFilters['email'])) {
                $query->where('users.email', 'LIKE', '%' . $searchFilters['email'] . '%');
            }

            if (isset($searchFilters['name'])) {
                $query->where('users.name', 'LIKE', '%' . $searchFilters['name'] . '%');
            }

            if (isset($searchFilters['phone'])) {
                $query->where('users.phone', 'LIKE', '%' . $searchFilters['phone'] . '%');
            }
        });

        return $dataTable->make(true);
    }

    public function add() {
        return view('admin.users.add');
    }

    public function insert(Request $request) {

        $formData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'file', 'image'],
        ]);

        $formData['status'] = User::STATUS_ENABLED;
        $formData['password'] = \Hash::make(\Str::random(8));

        $newUser = new User();
        $newUser->fill($formData);
        $newUser->save();

        $this->handlePhotoUpload($request, $newUser);

        session()->flash('system_message', __('New user has been saved!'));
        return redirect()->route('admin.users.index');
    }

    public function edit(Request $request, User $user) {

        if (\Auth::user()->id == $user->id) {
            session()->flash('system_error', __('You can not edit your account!'));
            return redirect()->route('admin.users.index');
        }

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user) {

        if (\Auth::user()->id == $user->id) {
            session()->flash('system_error', __('You can not update your account!'));
            return redirect()->route('admin.users.index');
        }

        $formData = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->where('email')->ignore($user->id)],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'file', 'image'],
        ]);

        $user->fill($formData);
        $user->save();
        $this->handlePhotoUpload($request, $user);

        session()->flash('system_message', __('User has been saved!'));
        return redirect()->route('admin.users.index');
    }

    public function disable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id'],
        ]);

        $user = User::findOrFail($formData['id']);

        if (\Auth::user()->id == $user->id) {
            return response()->json([
                        'system_error' => __('You can not disable your account!')
                            ], 403);
        }
        $user->status = User::STATUS_DISABLED;
        $user->save();

        return response()->json([
                    'system_message' => __('User has been disabled')
        ]);
    }

    public function enable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:users,id'],
        ]);

        $user = User::findOrFail($formData['id']);

        if (\Auth::user()->id == $user->id) {
            return response()->json([
                        'system_error' => __('You can not enable your account!')
                            ], 403);
        }

        $user->status = User::STATUS_ENABLED;
        $user->save();

        return response()->json([
                    'system_message' => __('User has been enabled')
        ]);
    }

    public function deletePhoto(Request $request, User $user) {
        $user->deletePhoto();
        $user->photo = null;
        $user->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted'),
                    'photo_url' => $user->getPhotoUrl(),
        ]);
    }

    protected function handlePhotoUpload(Request $request, User $user) {
        if ($request->hasFile('photo')) {
            $user->deletePhoto();

            $photoFile = $request->file('photo');
            $newPhotoFileName = $user->id . '_' . $photoFile->getClientOriginalName();
            $photoFile->move(public_path('/storage/users/'), $newPhotoFileName);
            $user->photo = $newPhotoFileName;
            $user->save();

            \Image::make(public_path('/storage/users/' . $user->photo))
                    ->fit(256, 256)
                    ->save();
        }
    }

}
