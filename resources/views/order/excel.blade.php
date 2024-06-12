<table style="width: 100%; border: 2px solid #000;">
    <thead>
        <tr>
            <th colspan="9" style="font-size: 13px; font-weight: bold; text-align:center;">Laporan Order {{ $setting->nama_website }}</th>
        </tr>
        <tr>
            <th colspan="4">Dari : {{ \Carbon\Carbon::parse($dari)->format('d M Y') }}</th>
            <th></th>
            <th colspan="4">Sampai : {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Kode Klien</th>
            <th>Karyawan</th>
            <th>Jenis</th>
            <th>Bobot</th>
            <th>Ket. Bobot</th>
            <th>Tanggal Order</th>
            <th>Deadline</th>
            <th>Progress</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order as $no => $row)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->kode_klien }}</td>
                <td>{{ $row->user->name }}</td>
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
                <td>
                    @if($row->status == 0)
                        Belum dibayar
                    @elseif($row->status == 1)
                        Sedang diproses
                    @elseif($row->status == 2)
                        Order Selesai
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>