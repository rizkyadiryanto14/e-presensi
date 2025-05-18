<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }
        .stats {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f0f0f0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Laporan Absensi Guru - {{ $formattedMonth }}</h1>

<div class="stats">
    <table border="0">
        <tr>
            <td width="150">Total Guru</td>
            <td>: {{ $monthlyStats['total_guru'] }}</td>
            <td width="150">Hari Kerja</td>
            <td>: {{ $monthlyStats['working_days'] }}</td>
        </tr>
        <tr>
            <td>Hadir</td>
            <td>: {{ $monthlyStats['hadir'] }}</td>
            <td>Terlambat</td>
            <td>: {{ $monthlyStats['terlambat'] }}</td>
        </tr>
        <tr>
            <td>Izin</td>
            <td>: {{ $monthlyStats['izin'] }}</td>
            <td>Tidak Hadir</td>
            <td>: {{ $monthlyStats['tidak_hadir'] }}</td>
        </tr>
        <tr>
            <td>Persentase Kehadiran</td>
            <td colspan="3">: {{ $monthlyStats['persentase_kehadiran'] }}%</td>
        </tr>
    </table>
</div>

<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Guru</th>
        <th>NIP</th>
        <th>Total</th>
        <th>Hadir</th>
        <th>Terlambat</th>
        <th>Izin</th>
        <th>Tidak Hadir</th>
        <th>Persentase</th>
    </tr>
    </thead>
    <tbody>
    @foreach($summaries as $index => $summary)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $summary['guru']->nama }}</td>
            <td>{{ $summary['guru']->nip }}</td>
            <td class="text-center">{{ $summary['total'] }}</td>
            <td class="text-center">{{ $summary['hadir'] }}</td>
            <td class="text-center">{{ $summary['terlambat'] }}</td>
            <td class="text-center">{{ $summary['izin'] }}</td>
            <td class="text-center">{{ $summary['tidak_hadir'] }}</td>
            <td class="text-center">
                @php
                    $percentage = 0;
                    if ($monthlyStats['working_days'] > 0) {
                        $percentage = round(($summary['hadir'] + $summary['terlambat'] + $summary['izin']) / $monthlyStats['working_days'] * 100);
                    }
                @endphp
                {{ $percentage }}%
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">
    <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
</div>
</body>
</html>
