@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Breadcrumb -->
    <div class="flex items-center space-x-2 text-xs text-slate-500">
        <a href="{{ route('users.index') }}" class="hover:text-indigo-600 font-medium transition">User Management</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Edit User #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <div class="mb-6 pb-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Edit User Profile</h1>
                <p class="text-xs text-slate-500 mt-1">Update profile information, roles, or reset account password.</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center border border-indigo-100">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                    Full Name <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 border @error('name') border-rose-500 @else border-slate-200 @enderror rounded-xl text-slate-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                @error('name')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                    Email Address <span class="text-rose-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}" 
                       required 
                       class="w-full px-4 py-2.5 bg-slate-50 border @error('email') border-rose-500 @else border-slate-200 @enderror rounded-xl text-slate-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                @error('email')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label for="role" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                    System Role <span class="text-rose-500">*</span>
                </label>
                <select id="role" 
                        name="role" 
                        required 
                        class="w-full px-4 py-2.5 bg-slate-50 border @error('role') border-rose-500 @else border-slate-200 @enderror rounded-xl text-slate-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Regular User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
                @error('role')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Optional Password Change Section -->
            <div class="pt-4 border-t border-slate-100">
                <div class="mb-3">
                    <h2 class="text-sm font-bold text-slate-800">Change Password (Optional)</h2>
                    <p class="text-xs text-slate-500">Leave these fields blank if you do not wish to update the password.</p>
                </div>

                <div class="space-y-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                            New Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Leave blank to keep existing password"
                                   oninput="checkPasswordRequirements(this.value)"
                                   class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border @error('password') border-rose-500 @else border-slate-200 @enderror rounded-xl text-slate-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('password', this)" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="fa-regular fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror

                        <!-- Password rules checklist -->
                        <div id="password-checklist" class="hidden mt-3 p-3 rounded-xl bg-slate-50 border border-slate-200 space-y-1 text-xs">
                            <div class="text-[11px] font-semibold uppercase tracking-wider text-slate-500 mb-1">
                                Strict Password Requirements:
                            </div>
                            <div id="rule-length" class="flex items-center text-slate-500">
                                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                                <span>At least <strong>10 characters</strong></span>
                            </div>
                            <div id="rule-upper" class="flex items-center text-slate-500">
                                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                                <span>At least <strong>1 uppercase letter</strong> (A-Z)</span>
                            </div>
                            <div id="rule-special" class="flex items-center text-slate-500">
                                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                                <span>At least <strong>1 special character</strong> (@$!%*?&#)</span>
                            </div>
                            <div id="rule-number" class="flex items-center text-slate-500">
                                <i class="fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center"></i>
                                <span>At least <strong>1 number</strong> (0-9)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                            Confirm New Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirm new password"
                                   class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('password_confirmation', this)" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                                <i class="fa-regular fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                <a href="{{ route('users.index') }}" 
                   class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl text-sm transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm shadow-md shadow-indigo-600/20 transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    function checkPasswordRequirements(value) {
        const checklist = document.getElementById('password-checklist');
        if (value.length > 0) {
            checklist.classList.remove('hidden');
        } else {
            checklist.classList.add('hidden');
        }

        updateRuleUI('rule-length', value.length >= 10);
        updateRuleUI('rule-upper', /[A-Z]/.test(value));
        updateRuleUI('rule-special', /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]/.test(value));
        updateRuleUI('rule-number', /[0-9]/.test(value));
    }

    function updateRuleUI(elementId, isValid) {
        const el = document.getElementById(elementId);
        if (!el) return;
        const icon = el.querySelector('i');
        
        if (isValid) {
            el.className = 'flex items-center text-emerald-600 transition-colors';
            icon.className = 'fa-solid fa-circle-check text-emerald-500 mr-2 w-3.5 text-center';
        } else {
            el.className = 'flex items-center text-slate-500 transition-colors';
            icon.className = 'fa-solid fa-circle-xmark text-slate-400 mr-2 w-3.5 text-center';
        }
    }
</script>
@endsection

