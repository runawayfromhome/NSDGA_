<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSDGA | System Settings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex text-slate-900 font-inter">

    <x-admin.sidebar />

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md shadow-sm p-4 sticky top-0 z-10 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-800 tracking-tight ml-4">System Settings</h2>
        </header>

        <div class="p-8 max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="space-y-2">
                    <button class="w-full text-left px-4 py-3 rounded-xl bg-blue-600 text-white font-bold shadow-md shadow-blue-200 transition-all">
                        General Settings
                    </button>
                    <button class="w-full text-left px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-200 font-bold transition-all">
                        Security & Auth
                    </button>
                    <button class="w-full text-left px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-200 font-bold transition-all">
                        Email (SMTP) Config
                    </button>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-6 border-b border-slate-100">
                            <h3 class="font-bold text-slate-800">General Information</h3>
                            <p class="text-slate-400 text-xs mt-1">Configure your school's public profile and active semester.</p>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">School Name</label>
                                    <input type="text" name="school_name" value="Nuestra Señora de Guia Academy" 
                                           class="w-full mt-2 p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 outline-none">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Current Academic Year</label>
                                        <select name="academic_year" class="w-full mt-2 p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                                            <option>2025-2026</option>
                                            <option selected>2026-2027</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Semester</label>
                                        <select name="semester" class="w-full mt-2 p-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                                            <option selected>1st Semester</option>
                                            <option>2nd Semester</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Maintenance Mode</p>
                                    <p class="text-xs text-slate-400">Disable student access during updates.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="maintenance" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>