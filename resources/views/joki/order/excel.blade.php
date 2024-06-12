<table style="width: 100%; border: 2px solid #000;">
    <thead>
        <tr>
            <th colspan="8" style="font-size: 13px; font-weight: bold; text-align:center;">Laporan Kerja {{ $setting->nama_website }}</th>
        </tr>
        <tr>
            <td>Nama</td>
            <th>: {{ Auth::user()->name }}</th>
        </tr>
        <tr>
            <td>Tanggal</td>
            <th>: {{ \Carbon\Carbon::parse($dari)->format('d M').' - '.\Carbon\Carbon::parse($sampai)->format('d M Y') }}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Kode Klien</th>
            <th>Jenis</th>
            <th>Bobot</th>
            <th>Ket Bobot</th>
            <th>Tanggal Order</th>
            <th>Deadline</th>
            <th>Progress</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order as $no => $row)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->kode_klien }}</td>
                <td>
                    @php
                        $jenis = array();
                        foreach ($row->jenisorder as $value) {
                            $jenis[] = $value->jenis->judul;
                        }
                        echo implode(', ', $jenis);
                    @endphp
                </td>
                <td>{{ strtoupper($row->bobot->bobot) }}</td>
                <td>{{ strtoupper($row->keterangan) }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($row->deadline)->format('d M Y') }}
                </td>
                <td>
                    @if($row->activity <> '')
                        {{ $row->activity->judul_aktivitas }}
                    @else
                        Belum ada progress
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <th colspan="6" style="font-size: 11px; font-weight: bold; text-align:center;">Jumlah Job</th>
            <th colspan="2" style="font-size: 11px; font-weight: bold; text-align:center;">{{ $ordercount }}</th>
        </tr>
    </tbody>
</table>