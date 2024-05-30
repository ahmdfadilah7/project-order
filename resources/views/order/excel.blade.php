<table style="width: 100%; border: 2px solid #000;">
    <thead>
        <tr>
            <th colspan="10" style="font-size: 13px; font-weight: bold; text-align:center;">Laporan Order {{ $setting->nama_website }}</th>
        </tr>
        <tr>
            <th>No</th>
            <th>Kode Order</th>
            <th>Karyawan</th>
            <th>Pelanggan</th>
            <th>Project</th>
            <th>Jenis</th>
            <th>Bobot</th>
            <th>Keterangan Bobot</th>
            <th>Deadline</th>
            <th>Progress</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order as $no => $row)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->kode_order }}</td>
                <td>{{ $row->user->name }}</td>
                <td>{{ $row->pelanggan->name }}</td>
                <td>{{ $row->judul }}</td>
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
    </tbody>
</table>