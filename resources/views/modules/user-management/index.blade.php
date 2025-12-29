@extends('layouts.admin')

@section('content')
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Kelola User</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">Daftar user pada sistem e-presensi</p>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table
            id="search-table"
            data-table-search="true"
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                <span class="flex items-center">
                    Company Name
                </span>
                </th>
                <th scope="col" class="px-6 py-3">
                <span class="flex items-center">
                    Ticker
                </span>
                </th>
                <th scope="col" class="px-6 py-3">
                <span class="flex items-center">
                    Stock Price
                </span>
                </th>
                <th scope="col" class="px-6 py-3">
                <span class="flex items-center">
                    Market Capitalization
                </span>
                </th>
            </tr>
            </thead>

            <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    Apple Inc.
                </td>
                <td class="px-6 py-4">AAPL</td>
                <td class="px-6 py-4">$192.58</td>
                <td class="px-6 py-4">$3.04T</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableEl = document.getElementById("search-table");

            if (!tableEl || typeof simpleDatatables === 'undefined') return;

            new simpleDatatables.DataTable(tableEl, {
                searchable: true,        // search box
                sortable: true,          // sorting header

                perPage: 5,              // default rows per page
                perPageSelect: [5, 10, 15, 20], // dropdown jumlah baris

                fixedHeight: true,        // agar tabel tidak berubah tinggi saat pagination

                labels: {
                    placeholder: "Cari...",      // placeholder search
                    perPage: "{select} per halaman",
                    noRows: "Data tidak ditemukan",
                    info: "Menampilkan {start}–{end} dari {rows} data"
                }
            });
        });
    </script>
@endpush
