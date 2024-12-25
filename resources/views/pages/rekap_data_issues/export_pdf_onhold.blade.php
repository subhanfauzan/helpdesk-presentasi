<!DOCTYPE html>
<html>

<head>
    <title>Rekap issues</title>
    <style type="text/css">
        body {
            /* font-family: "Times New Roman", Times, serif; */
            font-family: "arial";
            font-size: 10pt;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-lowercase {
            text-transform: lowercase;
        }

        .text-capital {
            text-transform: capitalize;
        }

        .text-underline {
            text-decoration: underline;
            text-decoration-color: #000;
        }

        .font-sm {
            font-size: 12px;
        }

        .bg-red {
            background-color: red;
        }

        .bg-grey {
            background-color: rgb(220, 220, 220);
        }

        .table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: solid 1px black;
        }

        .table th,
        .table td {
            border: 1px solid black;
            font-size: 12px;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mt-0 {
            margin-top: 0px;
        }

        .my-0 {
            margin-bottom: 0px;
            margin-top: 0px;
        }

        .mb-1 {
            margin-bottom: 1.5px;
        }

        hr {
            display: block;
            margin-top: 0.3em;
            margin-bottom: -0.2em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 3px;
            color: black;
        }

        ol {
            display: block;
            margin-top: 0em;
            margin-bottom: 1em;
            margin-left: 0;
            margin-right: 0;
            padding-left: 17px;
            padding-top: -15px;
        }

        .th_ {
            font-size: 8pt;
        }

        img {
            width: 130px;
        }

        .qr {
            width: 95px;
        }

        #footer{
            border: 0px;
            text-align: left;
            margin-top: 5px;
        }

        #footer td{
            border: 0px;
            text-align: left;
        }
    </style>
</head>

<body style="font-family: 'Serif'" onload="chart()">
    <header>
        <table border="0" style="width: 100%;">
            <tr>

                <td class="text-center" style="width: 100%">
                    <p style="font-size:20pt;">Laporan Harian Layanan Helpdesk TI PI PG</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:10pt;" class="text-start">Tanggal Issue: {{ $awal }} - {{ $akhir }}
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="font-size:10pt;" class="text-start">Tanggal Laporan: {{ Date('Y-m-d') }}</p>
                </td>
            </tr>
        </table>
        <!-- <img src="https://quickchart.io/chart?width=500&height=300&chart={
                type:'pie',
                data:{
                    labels:['January','February', 'March','April', 'May'], 
                    datasets:[{
                        label:'Dogs',
                        data:[50,60,70,180,190]
                        }]
                    }
                }"
            style="width:250px; height:150px;" /> -->
    </header>

    <br>
    <br>
    <h2 class="text-center" style="margin-bottom: 0px;">ON HOLD</h2>
    <p class="text-center" style="margin-top: 1px;margin-bottom: 1px;">({{ $issues->count() }}) Issues</p>
    <div style="width: 100%; float: left;">
        <table class="table text-center">
            <thead class="text-center">
                <tr style="background-color:rgb(0, 102, 255)">
                    <th width="3%">No.</th>
                    <th width="9%">ID Tiket Nama Layanan</th>
                    <th width="10%">Nama Subjek</th>
                    <th width="6%">User Entry</th>
                    {{-- <th width="6%">Nama Peminta</th> --}}
                    <th width="8%">Requester</th>
                    <th width="7%">Tanggal Lapor - Tanggal batas</th>
                    <th width="6%">Prioritas</th>
                    <th width="5%">SLA (Hari Kerja)</th>
                    <th width="6%">Realisasi SLA</th>
                    <th width="7%">Status</th>
                    <th width="14%">Deskripsi/Permintaan</th>
                    <th width="8%">Ekskalasi PI</th>
                    <th width="11%">Note</th>
                </tr>
            </thead>
            <tbody>
                <?php $ai = 1; ?>
                <?php $jumlah_eskalasi_pi = 0; ?>
                <?php $jumlah_kategori_subject_inc = 0; ?>
                <?php $jumlah_kategori_subject_req = 0; ?>
                <?php $jumlah_major_incident = 0; ?>
                <?php $jumlah_security_incident = 0; ?>
                @foreach ($issues as $issue)
                    <tr>
                        <td>{{ $ai++ }}</td>
                        <td>
                            {{-- <img style="margin: 2px;" class="qr"
                                src="data:image/png;base64, {!! base64_encode(
                                    QrCode::format('png')->merge(public_path('image/Petro_logo.png'), 0.3, true)->size(500)->errorCorrection('H')->generate($issue->tiket),
                                ) !!} "> --}}
                            {{ $issue->tiket }}<br> {{ $issue->kategori }}
                        </td>
                        <td>
                            <?php
                                if($issue->kategori_subject == 'INC'){
                                    $jumlah_kategori_subject_inc ++;
                                }
                                if($issue->kategori_subject == 'REQ'){
                                    $jumlah_kategori_subject_req ++;
                                }
                            ?>
                            {{ $issue->kategori_subject ? $issue->kategori_subject . '-' : '' }}{{ $issue->subject }} <br>({{ $issue->layanan }})
                        </td>
                        <td>{{ $issue->creator }}</td>
                        {{-- <td>{{ $issue->peminta }}</td> --}}
                        <td>{{ $issue->requester }}<br>NIK {{ $issue->nik }}<br> {{ $issue->unit }}</td>
                        <td>{{ $issue->tgllapor }} <br>-<br> {{ $issue->tglbatas }}</td>
                        <td {!! mappingPriorityPDF($issue->priority_id) !!}><?php $prioritas = explode(' ', $issue->prioritas, 2); ?>
                            {{ $prioritas['0'] }}<br>
                            {{ $prioritas['1'] }}</td>
                        <td>{{ $issue->sla }}</td>
                        <td>
                            @php
                                $tgldone = Date('Y-m-d H:i:s');
                            @endphp
                            {!! hitungSLA($issue->tgllapor, $issue->tglbatas, $tgldone, $issue->status, $issue->tiket) !!}
                        </td>
                        <td><?php
                        if ($issue->status == 1) {
                            echo 'Open';
                        } elseif ($issue->status == 2) {
                            echo 'Progress';
                        } elseif ($issue->status == 3) {
                            echo 'Done<br>' . $issue->lastupdate;
                        } elseif ($issue->status == 4) {
                            echo 'Closed<br>' . $issue->lastupdate;
                        } elseif ($issue->status == 6) {
                            echo 'On Hold<br>';
                        }
                        ?>
                        </td>
                        <td>
                            {!! $issue->deskripsi !!}
                        </td>
                        <td>
                            <?php
                                if($issue->tiket_cares_pi != null || $issue->tiket_cares_pi != ''){
                                    $jumlah_eskalasi_pi += 1;
                                }
                            ?>
                            {!! $issue->tiket_cares_pi !!}
                        </td>
                        <td>
                            @php
                                if ($issue->k_id == 'K11' && $issue->tiket_simasti != "" && $issue->tiket_simasti != null) {
                                    $subjects = explode('~', $issue->tiket_simasti);
                                    $note = 'Subject simasti:<br>';
                                    
                                    for($numb = 0; $numb < count($subjects); $numb++){
                                        
                                        if(isset($subjects[$numb])){
                                            $note = '';
                                        }else{
                                            $note .= ' ( ' . $kamus[$subjects[$numb]]['no_aset'] . ' - ' . $kamus[$subjects[$numb]]['model'] . ' - ' . $kamus[$subjects[$numb]]['nama_kategori'] . ' ) - ' . $kamus[$subjects[$numb]]['status_perbaikan'] . '; <br>';
                                        }
                                    }
                                } else {
                                    $note = '';
                                }
                            @endphp
                            {!! $note !!}

                            @if($issue->major_incident == 'true')
                                @php
                                    $jumlah_major_incident += 1;
                                    echo 'Major Incident';
                                @endphp
                            @endif

                            @if($issue->security_incident == 'true')
                                @php
                                    $jumlah_security_incident += 1;
                                    echo 'Security Incident';
                                @endphp
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table style="width: 22%;" id="footer">
            <tr>
                <td style="width: 70%">
                    <p style="font-size:10pt;" class="text-start">Jumlah Eskalasi PI</p>
                </td>
                <td style="width: 5%">
                    <p style="font-size:10pt;" class="text-start"> : </p>
                </td>
                <td style="width: 25%">{{$jumlah_eskalasi_pi}}</td>
            </tr>
            <tr>
                <td style="width: 70%">
                    <p style="font-size:10pt;" class="text-start">Jumlah Kategori INC</p>
                </td>
                <td style="width: 5%">
                    <p style="font-size:10pt;" class="text-start"> : </p>
                </td>
                <td style="width: 25%">{{$jumlah_kategori_subject_inc}}</td>
            </tr>
            <tr>
                <td style="width: 70%">
                    <p style="font-size:10pt;" class="text-start">Jumlah Kategori REQ</p>
                </td>
                <td style="width: 5%">
                    <p style="font-size:10pt;" class="text-start"> : </p>
                </td>
                <td style="width: 25%">{{$jumlah_kategori_subject_req}}</td>
            </tr>
            <tr>
                <td style="width: 75%">
                    <p style="font-size:10pt;" class="text-start">Jumlah Security Incident</p>
                </td>
                <td style="width: 5%">
                    <p style="font-size:10pt;" class="text-start"> : </p>
                </td>
                <td style="width: 20%">{{$jumlah_security_incident}}</td>
            </tr>
            <tr>
                <td style="width: 75%">
                    <p style="font-size:10pt;" class="text-start">Jumlah Major Incident</p>
                </td>
                <td style="width: 5%">
                    <p style="font-size:10pt;" class="text-start"> : </p>
                </td>
                <td style="width: 20%">{{$jumlah_major_incident}}</td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr style="border: 0px;">
                <td >
                    <br>
                    <br>
                    <table style="width: 100%;" id="footer">
                        <tr>
                            <td style="width: 58%">
                                <p style="font-size:10pt;" class="text-start">Distribusi: </p>
                            </td>
                            <td style="width: 20%"></td>
                            <td style="width: 2%"></td>
                            <td style="width: 20%"></td>
                        </tr>
                        <tr>
                
                            <td>
                                <p style="font-size:10pt;" class="text-start">1. Kepala TI PI PG</p>
                            </td>
                            <td>Disiapkan oleh:</td>
                            <td></td>
                            <td>Diperiksa oleh:</td>
                
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:10pt;" class="text-start">2. Staf Candal TI PI PG</p>
                            </td>
                            <td>Tim Helpdesk</td>
                            <td></td>
                            <td>Koordinator Tim Helpdesk</td>
                
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:10pt;" class="text-start">3. Spi IT Bisnis Partner</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:10pt;" class="text-start">4. Spi Infrastuktur</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:10pt;" class="text-start">5. Spi IT Services</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:10pt;" class="text-start">6. Arsip</p>
                            </td>
                            <td>{{ $tim }}</td>
                            <td></td>
                            <td>{{ $koor }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>

<!-- <script>
    window.print();
</script> -->
