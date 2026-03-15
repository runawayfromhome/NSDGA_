<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class LoginController extends Controller
{
    //  Process ng Login at Send ng OTP
   // Update your Login function to check for the lock immediately
public function login(Request $request)
{
    $credentials = $request->validate([
        'user' => 'required',
        'password' => 'required',
    ]);

    if (Auth::validate(['user' => $request->user, 'password' => $request->password])) {
        $user = User::where('user', $request->user)->first();

        // 1. Check if the account is locked BEFORE sending OTP
        if ($user->is_locked) {
            return back()->withErrors(['user' => 'This account has been locked. Please contact the administrator.']);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // Send SMS via Semaphore
        try {
            Http::asForm()->post('https://semaphore.co/api/v4/messages', [
                'apikey' => env('SEMAPHORE_API_KEY'),
                'number' => $user->phone_number,
                'message' => "Your NSDGA Security Code: {$otp}. Valid for 10 minutes.",
                'sendername' => 'SEMAPHORE'
            ]);
        } catch (\Exception $e) {
            \Log::error("SMS Failed: " . $e->getMessage());
        }

        session(['otp_user_id' => $user->id]);
        return redirect()->route('otp.view');
    }

    return back()->withErrors(['user' => 'The provided credentials do not match our records.']);
}

// ToggleLock for Security
public function toggleLock($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', "You cannot lock your own account!");
        }
        
        $user->is_locked = !$user->is_locked;
        $user->save();

        // --- UPDATED AUDIT LOG (using Model) ---
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => $user->is_locked ? 'Locked Account' : 'Unlocked Account',
            'target'     => $user->full_name . " ({$user->user})",
            'ip_address' => request()->ip(),
        ]);

        $status = $user->is_locked ? 'locked' : 'unlocked';
        return back()->with('success', "Account for {$user->full_name} has been {$status}.");
    }
    //  Pag Verify ng OTP and Redirect to Role-Specific Dashboard
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);
        $user = User::find(session('otp_user_id'));

        if ($user && $user->otp_code == $request->otp && now()->isBefore($user->otp_expires_at)) {
            
            // Clear OTP and Login the user
            $user->update(['otp_code' => null, 'otp_expires_at' => null]);
            Auth::login($user);
            session()->forget('otp_user_id');

            // Role-Based Redirection
           return match ($user->role) {
    'admin'     => redirect()->route('admin.dashboard'),
'registrar' => redirect()->route('registrar_dashboard'),
    default     => redirect('/login'),
};



        }

        return back()->withErrors(['otp' => 'The code is invalid or has expired.']);
    }
    // Pag Log out ng users
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Admin Creating User Account 
public function store(Request $request)
    {
        $newUser = User::create([
            'full_name'    => $request->full_name,
            'user'         => $request->user,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'password'     => bcrypt($request->pass),
            'role'         => $request->role,
        ]);

        // --- UPDATED AUDIT LOG (using Model) ---
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Created New Account',
            'target'     => $newUser->full_name . " ({$newUser->user})",
            'ip_address' => request()->ip(),
        ]);

        return back()->with('success', 'Account added successfully!');
    }

// Pag Resend ng OTP
public function resendOtp(Request $request)
{
    // Find the user from the temporary session ID
    $userId = session('otp_user_id');
    $user = \App\Models\User::find($userId);

    if (!$user) {
        return redirect()->route('login')->withErrors(['user' => 'Session expired. Please login again.']);
    }

    // Generate new 6-digit OTP
    $otp = rand(100000, 999999);
    $user->update([
        'otp_code' => $otp,
        'otp_expires_at' => now()->addMinutes(10), // Valid for 10 minutes
    ]);

    // Re-send SMS via Semaphore
    try {
        \Illuminate\Support\Facades\Http::asForm()->post('https://semaphore.co/api/v4/messages', [
            'apikey' => env('SEMAPHORE_API_KEY'),
            'number' => $user->phone_number,
            'message' => "Your NEW NSDGA Security Code: {$otp}. Valid for 10 minutes.",
        ]);
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error("Resend SMS Failed: " . $e->getMessage());
    }

    return back()->with('success', 'A new OTP has been sent to your phone.');
}


//This will delete User Accounts 
public function destroy($id)
    {
        try {
            $account = User::findOrFail($id);
            $targetName = $account->full_name; 

            $account->delete();

            // --- UPDATED AUDIT LOG (using Model) ---
            AuditLog::create([
                'user_id'    => Auth::id(),
                'action'     => 'Deleted Account',
                'target'     => $targetName,
                'ip_address' => request()->ip(),
            ]);

            return back()->with('success', 'Account deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete account.');
        }
    }

    // Processes the actual update
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

   $validated = $request->validate([
    'full_name'    => 'required|string|max:255',
    // Change 'users' to 'accounts' here
    'user'         => ['required', 'string', 'unique:accounts,user,' . $id],
    'email'        => ['required', 'email', 'unique:accounts,email,' . $id],
    'phone_number' => 'required|string',
    'role'         => 'required|in:admin,registrar',
    'pass'         => 'nullable|min:8', 
]);


    // Update basic info
    $user->full_name    = $request->full_name;
    $user->user         = $request->user;
    $user->email        = $request->email;
    $user->phone_number = $request->phone_number;
    $user->role         = $request->role;

    // Only update password if the field is not empty
    if ($request->filled('pass')) {
        $user->password = bcrypt($request->pass);
    }

    $user->save();

    // --- AUDIT LOG ---
    AuditLog::create([
        'user_id'    => Auth::id(),
        'action'     => 'Updated Account Info',
        'target'     => $user->full_name . " ({$user->user})",
        'ip_address' => request()->ip(),
    ]);

    return back()->with('success', "Account for {$user->full_name} updated successfully!");
}

// Optional: If you use a separate page or AJAX to get user data
public function edit($id)
{
    $user = User::findOrFail($id);
    return response()->json($user); 
}
}


