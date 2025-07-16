<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Klien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 rounded-lg mb-6 font-semibold">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama Klien
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status Verifikasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status Sorotan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $user->name }} <br>
                                            <span class="text-xs text-gray-500">{{ $user->email }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($user->is_verified_local_business)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Terverifikasi
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Belum Diverifikasi
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($user->is_featured)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    Disorot
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-4">
                                                @if(!$user->is_verified_local_business)
                                                    <form action="{{ route('admin.users.verify', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memverifikasi bisnis ini?');">
                                                        @csrf
                                                        <button type="submit" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-200">
                                                            Verifikasi
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Tombol untuk Toggle Feature --}}
                                                <form action="{{ route('admin.users.toggle-feature', $user) }}" method="POST">
                                                    @csrf
                                                    @if($user->is_featured)
                                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-colors duration-200">
                                                            Batal Sorot
                                                        </button>
                                                    @else
                                                        <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition-colors duration-200">
                                                            Sorot
                                                        </button>
                                                    @endif
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            Belum ada klien yang terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
