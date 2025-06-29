<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();

        return response()->json($cities);
    }
    public function showregister()
    {
        $states = State::all();
        return view('auth.register', compact('states'));
    }



    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|digits:10',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|min:5',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'password' => $request->password,
        ]);

        return redirect()->route('showlogin')->with('success', 'Registration successful! Please login.');
    }
    public function showlogin()
    {
        return view('auth.login');
    }


    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'user') {
            // $name=$user->name;
            // $id=$user->id;
            return redirect()->route('user.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('showlogin')->withErrors(['email' => 'Unauthorized role.']);
        }
    }

    return redirect()->route('showlogin')->withErrors([
        'email' => 'Invalid email or password.',
    ]);
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showlogin')->with('success', 'Logged out successfully!');
    }
    public function dashboard()
    {
        $user = Auth::user(); // logged-in user
        if($user->role === 'admin')
        {
            return view('admin.dashboard',[
                'admin_id' => $user->id,
                'admin_name' => $user->name,
            ]);
        }else {
        return view('auth.dashboard', [
            'user_id' => $user->id,
            'user_name' => $user->name
        ]);
    }
    }
    public function editProfile()
    {
        $states = \App\Models\State::all();
        $user = Auth::user(); // current logged-in user

        return view('auth.register', [
            'states' => $states,
            'userData' => $user,
            'isEdit' => true,
        ]);
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
        ]);

        // $user = Auth::user();
        $user = User::find(Auth::id());
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile'), $imageName);
            $user->profile_image = $imageName;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully!');
    }

    public function checkEmail(Request $request)
    {
        $exists = \App\Models\User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}
