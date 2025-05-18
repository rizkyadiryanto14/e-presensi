@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Guru</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Edit data guru</p>
        </div>

        <div>
            <a href="{{ route('admin.guru.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 card-shadow overflow-hidden">
        <div class="p-5 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-800 dark:text-gray-100">Form Edit Guru</h3>
        </div>

        <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">
                <!-- Informasi Guru -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Informasi Guru</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIP <span class="text-red-500">*</span></label>
                            <input type="text" id="nip" name="nip" value="{{ old('nip', $guru->nip) }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md @error('nip') border-red-500 @enderror" placeholder="Masukkan NIP">
                            @error('nip')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama', $guru->nama) }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md @error('nama') border-red-500 @enderror" placeholder="Masukkan Nama Lengkap">
                            @error('nama')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="jabatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jabatan <span class="text-red-500">*</span></label>
                            <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $guru->jabatan) }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md @error('jabatan') border-red-500 @enderror" placeholder="Contoh: Guru Matematika">
                            @error('jabatan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status_kepegawaian" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Kepegawaian <span class="text-red-500">*</span></label>
                            <select id="status_kepegawaian" name="status_kepegawaian" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md @error('status_kepegawaian') border-red-500 @enderror">
                                <option value="" disabled>Pilih Status</option>
                                <option value="tetap" {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'tetap' ? 'selected' : '' }}>Tetap</option>
                                <option value="kontrak" {{ old('status_kepegawaian', $guru->status_kepegawaian) == 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                            </select>
                            @error('status_kepegawaian')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Finansial -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Informasi Finansial</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="gaji_pokok" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gaji Pokok (Rp) <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $guru->gaji_pokok) }}" class="pl-12 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md @error('gaji_pokok') border-red-500 @enderror" placeholder="0">
                            </div>
                            @error('gaji_pokok')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tunjangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tunjangan (Rp)</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" id="tunjangan" name="tunjangan" value="{{ old('tunjangan', $guru->tunjangan) }}" class="pl-12 focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md @error('tunjangan') border-red-500 @enderror" placeholder="0">
                            </div>
                            @error('tunjangan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Akun -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Informasi Akun</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $guru->user->email) }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md @error('email') border-red-500 @enderror" placeholder="contoh@email.com">
                            @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengubah email.</p>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
                            <input type="password" id="password" name="password" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md @error('password') border-red-500 @enderror" placeholder="Masukkan password baru">
                            @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengubah password.</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md" placeholder="Masukkan password baru kembali">
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 text-right">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
