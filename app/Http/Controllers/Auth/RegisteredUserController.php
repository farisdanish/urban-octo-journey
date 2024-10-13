<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Helpers\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            $customer = new Customer();
            $names = explode(" ", $user->name);
            $customer->user_id = $user->id;
            $customer->first_name = $names[0];
            $customer->last_name = $names[1] ?? '';
            $customer->save();

            Auth::login($user);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->withInput()->with('error', 'Unable to register right now.');
        // }
        } catch (\Exception $e) {
            DB::rollBack();
        
            // Log the error to the log files
            Log::error('Registration failed: ' . $e->getMessage(), [
                'exception' => $e, // Include the exception in the logs
            ]);
        
            // Display a generic error message to the user
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while trying to register. Please try again later.');
        }
        

        DB::commit();

        Cart::moveCartItemsIntoDb();

        return redirect(RouteServiceProvider::HOME);
    }
}
