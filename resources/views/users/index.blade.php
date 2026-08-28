@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">User Management</h1>
            <p class="text-xs text-slate-500 mt-1">Manage system accounts, roles, and administrative privileges.</p>
        </div>
        <a href="{{ route('users.create') }}" 
           class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-600/20 transition">
            <i class="fa-solid fa-user-plus mr-2 text-xs"></i> Add New User
        </a>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <form method="GET" action="{{ route('users.index') }}" class="flex flex-col md:flex-row items-center gap-3">
            <!-- Search Field -->
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by user name or email address..." 
                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
            </div>

            <!-- Role Filter -->
            <div class="w-full md:w-44">
                <select name="role" 
                        onchange="this.form.submit()" 
                        class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-hidden focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="flex items-center space-x-2 w-full md:w-auto">
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-medium transition flex-1 md:flex-none">
                    Filter
                </button>
                @if(request('search') || request('role'))
                    <a href="{{ route('users.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">User</th>
                        <th class="py-3.5 px-4">Role</th>
                        <th class="py-3.5 px-4 hidden sm:table-cell">Created Date</th>
                        <th class="py-3.5 px-4 text-right sm:px-6">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $userItem)
                        <tr class="hover:bg-slate-50/60 transition">
                            <!-- User Info -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center text-sm border border-indigo-100">
                                        {{ strtoupper(substr($userItem->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900 flex items-center space-x-2">
                                            <span>{{ $userItem->name }}</span>
                                            @if($userItem->id === Auth::id())
                                                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-indigo-100 text-indigo-700 rounded-md">You</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $userItem->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td class="py-4 px-4">
                                @if($userItem->isAdmin())
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                                        <i class="fa-solid fa-shield-halved text-[10px] mr-1.5"></i> Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        <i class="fa-solid fa-user text-[10px] mr-1.5 text-slate-500"></i> User
                                    </span>
                                @endif
                            </td>

                            <!-- Created Date -->
                            <td class="py-4 px-4 text-xs text-slate-500 hidden sm:table-cell">
                                {{ $userItem->created_at ? $userItem->created_at->format('M d, Y') : 'N/A' }}
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="inline-flex items-center space-x-1.5">
                                    <a href="{{ route('users.edit', $userItem) }}" 
                                       class="p-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                       title="Edit User">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>

                                    @if($userItem->id !== Auth::id())
                                        <form action="{{ route('users.destroy', $userItem) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete user \'{{ $userItem->name }}\'? This action cannot be undone.');" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                    title="Delete User">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-400 text-sm">
                                <i class="fa-solid fa-users-slash text-2xl text-slate-300 mb-2 block"></i>
                                No users found matching your search criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

