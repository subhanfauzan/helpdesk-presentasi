<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $judul }}</title>
    <style type="text/css">
    </style>
</head>

<body>
    <table>
        <tr style="background-color: rgb(0, 110, 255)">
            <th>
                <div align="center">Id Tiket Nama Layanan</div>
            </th>
            <th>
                <div align="center">Nama Subjek</div>
            </th>
            <th>
                <div align="center">User entry</div>
            </th>
            {{-- <th>
                <div align="center">Nama Peminta</div>
            </th> --}}
            <th>
                <div align="center">Requester</div>
            </th>
            <th>
                <div align="center">Tanggal Lapor - Tanggal batas</div>
            </th>
            <th>
                <div align="center">Prioritas</div>
            </th>
            <th>
                <div align="center">SLA (Hari Kerja)</div>
            </th>
            <th>
                <div align="center">Realisasi SLA</div>
            </th>
            <th>
                <div align="center">Status</div>
            </th>
            <th>
                <div align="center">Deskripsi/Permintaan</div>
            </th>
            <th>
                <div align="center">Eskalasi PI</div>
            </th>
            <th>
                <div align="center">Note &emsp;</div>
            </th>
        </tr>
        @foreach ($issues as $issue)
            <tr>
                <td>
                    <br>
                    {{ $issue->tiket }} {{ $issue->kategori }}
                </td>
                <td>{{ $issue->subject }} ({{ $issue->layanan }})</td>
                <td>{{ $issue->creator }}</td>
                {{-- <td>{{ $issue->peminta }}</td> --}}
                <td>{{ $issue->requester }}<br>NIK {{ $issue->nik }} <br>{{ $issue->unit }}</td>
                <td>{{ $issue->tgllapor }} - {{ $issue->tglbatas }}</td>
                <td> <?php $prioritas = explode(' ', $issue->prioritas, 2); ?>
                    {{ $prioritas['0'] }}<br>
                    {{ $prioritas['1'] }}
                </td>
                <td>{{ $issue->sla }}</td>
                <td>@php
                    if($issue->sladone == null){
                        $tgldone = Date('Y-m-d H:i:s');
                        $realisasi = hitungSLA($issue->tgllapor, $issue->tglbatas, $tgldone, $issue->status, $issue->tiket);
                    }else{
                        $realisasi = $issue->sladone;
                    }
                @endphp
                {!! $realisasi !!}
                </td>
                <td><?php
                if ($issue->status == 1) {
                    echo 'Open';
                } elseif ($issue->status == 2) {
                    echo 'Progress';
                } elseif ($issue->status == 3) {
                    echo 'Done<br>' . ambilTanggalDone($issue->tiket);
                } elseif ($issue->status == 4) {
                    echo 'Closed<br>' . ambilTanggalDone($issue->tiket);
                } elseif ($issue->status == 6) {
                    echo 'On Hold';
                }
                ?>
                </td>
                <td>
                    @php
                        echo strip_tags(preprocessing_get_string($issue->deskripsi));
                    @endphp
                </td>
                <td></td>
                <td>
                    @php
                        if ($issue->k_id == 'K11' && $issue->tiket_simasti != "" && $issue->tiket_simasti != null) {
                                $subjects = explode('~', $issue->tiket_simasti);
                                $note = 'Subject simasti:<br>';
                                    
                                for($numb = 0; $numb < count($subjects); $numb++){
                                    $note .= ' ( ' . $kamus[$subjects[$numb]]['no_aset'] . ' - ' . $kamus[$subjects[$numb]]['model'] . ' - ' . $kamus[$subjects[$numb]]['nama_kategori'] . ' ) - ' . $kamus[$subjects[$numb]]['status_perbaikan'] . '; <br>';
                                }
                            } else {
                            $note = '';
                        }
                    @endphp
                    {!! $note !!}
                </td>
            </tr>
        @endforeach
    </table>
    <br>
    <table>
        <tr>
            <td>Jumlah Issue: {{ $issues->count() }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>Distribusi: </p>
            </td>
            <td colspan="2"></td>
            <td></td>
        </tr>
        <tr>

            <td colspan="9">
                <p>1. Kepala TI PI PG</p>
            </td>
            <td colspan="2">Disiapkan oleh:</td>
            <td>Diperiksa oleh:</td>

        </tr>
        <tr>
            <td colspan="9">
                <p>2. Staf Candal TI PI PG</p>
            </td>
            <td colspan="2">Tim Helpdesk</td>
            <td>Koordinator Tim Helpdesk</td>

        </tr>
        <tr>
            <td>
                <p>3. Spi IT Bisnis Partner</p>
            </td>
            <td colspan="2"></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <p>4. Spi Infrastuktur</p>
            </td>
            <td colspan="2"></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <?php
                if ($judul == 'Open-Progress') {
                    echo '<p>5. Spi IT Services</p>';
                }
                ?>
            </td>
            <td colspan="2"></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="9">
                <?php
                if ($judul == 'Open-Progress') {
                    echo '<p>6. Arsip</p>';
                }
                ?>
            </td>
            <td colspan="2">{{ $tim }}</td>
            <td>{{ $koor }}</td>
        </tr>
    </table>
</body>

</html>
