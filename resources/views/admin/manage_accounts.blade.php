<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSDGA | Admin Dashboard</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-50 min-h-screen flex text-slate-900">

     <!-- ADMIN HEADER  -->

    <aside class="w-64 bg-slate-900 text-white hidden md:flex flex-col shadow-xl">
        <div class="p-6">
            <h1 class="text-2xl font-bold tracking-wider text-blue-400">NSDGA</h1>
            <p class="text-xs text-slate-400">School Management System</p>
        </div>



        <!-- ADMIN SIDE BAR  -->


        <nav class="flex-1 px-4 space-y-2 mt-4">
            <a href="#" class="flex items-center space-x-3 p-3 rounded-xl bg-blue-600 text-white font-semibold shadow-lg transition">
                <span>👤 Manage Accounts</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                <span>📚 Student Records</span>
            </a>
            <a href="#" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-slate-800 text-slate-300 transition">
                <span>⚙️ System Settings</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left p-3 text-red-400 hover:bg-red-500/10 rounded-xl transition font-medium">
                    🚪 Logout Account
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md shadow-sm p-4 flex justify-between items-center sticky top-0 z-10 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Accounts Management</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-semibold text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full border border-blue-100">
                    Admin: {{ Auth::user()->user }}
                </span>
            </div>
        </header>

        <!-- ADMIN CREATING ACCOUNT SECTION -->

        <div class="p-8">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <div class="xl:col-span-1 bg-white rounded-2xl shadow-sm border border-slate-200 h-fit">
                    <div class="bg-slate-900 p-5 rounded-t-2xl">
                        <h3 class="font-bold text-white flex items-center">
                            <span class="mr-2">➕</span> Add New User
                        </h3>
                    </div>
                    
                    {{-- Creating account  --}}
                    
                    <form action="{{ route('admin.store') }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @if(session('success'))
                            <div class="p-3 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg border border-emerald-200 animate-bounce">
                                ✅ {{ session('success') }}
                            </div>
                        @endif

                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Username/Work_ID</label>
                            <input type="text" name="user" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition">
                        @error('user')
                         <div style="color: #ff4d4d; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                        @enderror

                        </div>

                        <div>
                       <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Full Name</label>
                     <input type="text" name="full_name" required placeholder="Juan Dela Cruz" 
                      class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none transition">
                      </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gmail / Email</label>
                                <input type="email" name="email" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition" placeholder="example@gmail.com">
                         
                           
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Contact Number</label>
                                <input type="text" name="phone_number" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition" placeholder="09xxxxxxxxx">
                            @error('phone_number')
                          <div style="color: #ff4d4d; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                          @enderror
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Password</label>
                            <input type="password" name="pass" required class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition">
                        @error('pass')
                           <div style="color: #ff4d4d; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div>
                         @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">User Role</label>
                            <select name="role" class="w-full mt-1 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition cursor-pointer">
                           
                                <option value="registrar">Registrar</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition-all active:scale-95">
                            Register Account
                        </button>
                    </form>
                </div>

                <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Account Directory</h3>
                            <p class="text-xs text-slate-500">Manage school personnel access</p>
                        </div>
                        <span class="text-xs font-bold text-blue-600 bg-white border border-blue-100 px-3 py-1.5 rounded-lg shadow-sm">
                            Total: {{ count($accounts) }}
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
    <thead>
        <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-widest border-b border-slate-100">
            <th class="p-5">Employee_ID</th>
            <th class="p-5">Full Name</th>
            <th class="p-5">Contact Info</th>                                   
            <th class="p-5">Role</th>
            <th class="p-5">Status</th> <th class="p-5 text-center">Actions</th>
        </tr>
    </thead>

    

    <!-- ADMIN DELETE ACCOUNT SECTION 1 -->

    <tbody class="divide-y divide-slate-100 text-sm">
        @foreach($accounts as $acc)
        <tr class="hover:bg-blue-50/30 transition duration-150">
            <td class="p-5">
                <div class="font-bold text-slate-700">{{ $acc->user }}</div>
                <div class="text-[10px] text-slate-400">{{ $acc->email }}</div>
            </td>

            <td class="p-5">
                <div class="font-bold text-slate-700 capitalize">
                    {{ $acc->full_name ?? 'No Name' }}
                </div>
            </td>

            <td class="p-5">
                <div class="text-slate-600 font-medium">{{ $acc->phone_number }}</div>
            </td>

            <td class="p-5">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border
                    {{ $acc->role == 'admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-cyan-50 text-cyan-700 border-cyan-100' }}">
                    {{ $acc->role }}
                </span>
            </td>

            <td class="p-5">
                @if($acc->is_locked)
                    <span class="px-2 py-1 text-[10px] font-bold text-red-600 bg-red-50 border border-red-100 rounded-full">LOCKED</span>
                @else
                    <span class="px-2 py-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-full">ACTIVE</span>
                @endif
            </td>

            <td class="p-5 text-center flex justify-center space-x-2">
                <form action="{{ route('accounts.toggleLock', $acc->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2.5 rounded-xl transition-all {{ $acc->is_locked ? 'text-emerald-500 hover:bg-emerald-50' : 'text-slate-400 hover:bg-slate-100' }}" 
                            title="{{ $acc->is_locked ? 'Unlock Account' : 'Lock Account' }}">
                        {{ $acc->is_locked ? '🔓' : '🔒' }}
                    </button>
                </form>

                <form action="{{ route('admin.delete', $acc->id) }}" method="POST" onsubmit="return confirm('Delete this account?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2.5 text-red-400 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all">
                        🗑️
                    </button>
                </form>
                
            </td>
            <td class="p-5 text-center flex justify-center space-x-2">
    
    <form action="{{ route('accounts.toggleLock', $acc->id) }}" method="POST">
        @csrf
        ...
    </form>

    <!-- ADMIN DELETE ACCOUNT SECTION 2 -->

    <button type="button" 
            onclick="openEditModal({{ $acc }})"
            class="p-2.5 rounded-xl transition-all text-blue-500 hover:bg-blue-50 bg-slate-100" 
            title="Edit Account">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
    </button>

    <form action="{{ route('admin.delete', $acc->id) }}" method="POST" ...>
        @csrf
        @method('DELETE')
        ...
    </form>
</td>
        </tr>
        @endforeach
    </tbody>
</table>
                        </table>
                    </div>
                </div>

            </div>


<!-- ADMIN ACCOUNT DIRRECTORY THIS IS FOR EDIT BUTTON -->

      <div id="editModal" class="fixed inset-0 z-50 hidden transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="modalContainer">
            
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold tracking-tight">Edit Account</h3>
                        <p class="text-slate-400 text-xs mt-1">Update personnel access information</p>
                    </div>
                    <button onclick="closeEditModal()" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>



<!-- ADMIN ACCOUNT DIRRECTORY EDIT ACCOUNT SECTION 1  -->

            <form id="editForm" method="POST" class="p-8 space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Full Name</label>
                        <input type="text" name="full_name" id="edit_full_name" required 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Employee ID</label>
                            <input type="text" name="user" id="edit_user" required 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Role</label>
                            <select name="role" id="edit_role" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700 appearance-none">
                                <option value="admin">Admin</option>
                                <option value="registrar">Registrar</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Gmail / Email</label>
                        <input type="email" name="email" id="edit_email" required 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 ml-1">Contact Number</label>
                        <input type="text" name="phone_number" id="edit_phone" required 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700">
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <label class="block text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1 ml-1">Security Reset</label>
                        <input type="password" name="pass" placeholder="Enter new password to change" 
                            class="w-full px-4 py-3 bg-blue-50/30 border border-blue-100 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all text-slate-700 placeholder:text-blue-300 text-sm">
                    </div>
                </div>

                <div class="flex items-center space-x-3 pt-4">
                    <button type="button" onclick="closeEditModal()" 
                        class="flex-1 px-6 py-3.5 border border-slate-200 text-slate-500 font-bold rounded-2xl hover:bg-slate-50 transition-all active:scale-95">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="flex-1 px-6 py-3.5 bg-blue-600 text-white font-bold rounded-2xl shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition-all active:scale-95">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    

<!-- ADMIN ACCOUNT DIRRECTORY RECENT SYSTEM ACTIVITY  -->

<div class="mt-10 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md">
    
    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-gradient-to-r from-slate-50/50 to-white">
        <div class="flex items-center space-x-4">
            <div class="p-2.5 bg-slate-900 rounded-xl shadow-lg shadow-slate-200">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Recent System Activity</h3>
                <p class="text-[11px] text-slate-500 font-medium uppercase tracking-wider">Audit Trail & Security Logs</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full border border-blue-100">Live Updates</span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] bg-slate-50/30 border-b border-slate-100">
                    <th class="px-8 py-4">Administrator</th>
                    <th class="px-6 py-4">Action</th>
                    <th class="px-6 py-4">Target Person</th>
                    <th class="px-6 py-4">Network ID</th>
                    <th class="px-8 py-4 text-right">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($logs as $log)
                <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                    
                    <td class="px-8 py-5">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-[11px] font-bold text-blue-400 border-2 border-white shadow-sm">
                                {{ strtoupper(substr($log->user->full_name ?? 'S', 0, 1)) }}
                            </div>
                            <span class="font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">
                                {{ $log->user->full_name ?? 'System' }}
                            </span>
                        </div>
                    </td>

                    <td class="px-6 py-5">
                        @php
                            $action = strtolower($log->action);
                            $isDelete = str_contains($action, 'delete');
                            $isLock = str_contains($action, 'lock') || str_contains($action, 'unlocked');
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide border transition-all
                            {{ $isDelete ? 'bg-red-50 text-red-600 border-red-100 group-hover:bg-red-100' : ($isLock ? 'bg-amber-50 text-amber-600 border-amber-100 group-hover:bg-amber-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100 group-hover:bg-emerald-100') }}">
                            <span class="w-1 h-3 rounded-full mr-2 {{ $isDelete ? 'bg-red-400' : ($isLock ? 'bg-amber-400' : 'bg-emerald-400') }}"></span>
                            {{ $log->action }}
                        </span>
                    </td>

                    <td class="px-6 py-5">
                        <div class="flex items-center text-slate-600 font-medium">
                            <svg class="w-4 h-4 mr-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            {{ $log->target }}
                        </div>
                    </td>

                    <td class="px-6 py-5">
                        <span class="px-2 py-1 bg-white text-slate-400 rounded-md font-mono text-[10px] border border-slate-200 group-hover:border-slate-300 transition-colors">
                            {{ $log->ip_address }}
                        </span>
                    </td>

                    <td class="px-8 py-5 text-right">
                        <div class="text-slate-700 font-bold text-xs uppercase tracking-tighter">
                            {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        </div>
                        <div class="text-[10px] text-slate-400 font-medium">
                            {{ \Carbon\Carbon::parse($log->created_at)->format('h:i A · d M Y') }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-24 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <span class="text-2xl opacity-20">📁</span>
                            </div>
                            <p class="text-slate-400 font-bold text-sm tracking-tight">No activity logs found</p>
                            <p class="text-slate-300 text-xs mt-1">New administrative actions will appear here.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


        
    </main>

</body>
</html>
<script>
function openEditModal(account) {   
    const modal = document.getElementById('editModal');
    const container = document.getElementById('modalContainer');
    
    // Fill data
    document.getElementById('editForm').action = '/admin/update/' + account.id;
    document.getElementById('edit_full_name').value = account.full_name;
    document.getElementById('edit_user').value = account.user;
    document.getElementById('edit_email').value = account.email;
    document.getElementById('edit_phone').value = account.phone_number;
    document.getElementById('edit_role').value = account.role;

    // Show modal with animation
    modal.classList.remove('hidden');
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    const container = document.getElementById('modalContainer');

    container.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}
</script>