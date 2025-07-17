@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center space-x-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600">User</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span>Detail User</span>
        </div>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Detail User</h1>
                <p class="text-slate-600 mt-1">Informasi lengkap pengguna</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                            <i class="fas fa-trash"></i>
                            <span>Hapus</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
            <div class="text-white">
                <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                <p class="text-blue-100">{{ $user->email }}</p>
                <span class="inline-block px-3 py-1 mt-2 text-xs font-medium rounded-full {{ $user->role == 'admin' ? 'bg-purple-500 text-white' : 'bg-green-500 text-white' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <!-- User Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-user text-blue-500 mr-2"></i>
                        Informasi Personal
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Nama Lengkap</label>
                            <p class="text-slate-900 font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Email</label>
                            <p class="text-slate-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Telepon</label>
                            <p class="text-slate-900">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Role</label>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contact & System Information -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Informasi Sistem
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Terdaftar Pada</label>
                            <p class="text-slate-900">{{ $user->created_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Terakhir Diperbarui</label>
                            <p class="text-slate-900">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">Email Verified</label>
                            <p class="text-slate-900">
                                @if($user->email_verified_at)
                                    <span class="text-green-600 flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Terverifikasi
                                    </span>
                                @else
                                    <span class="text-red-600 flex items-center">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Belum Terverifikasi
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600">User ID</label>
                            <p class="text-slate-900 font-mono text-sm">#{{ $user->id }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            @if($user->address)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                        Alamat
                    </h3>
                    <div class="bg-slate-50 rounded-lg p-4">
                        <p class="text-slate-700">{{ $user->address }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.users.index') }}" class="text-slate-600 hover:text-slate-800 flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Daftar User</span>
                </a>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                        <i class="fas fa-edit"></i>
                        <span>Edit User</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
