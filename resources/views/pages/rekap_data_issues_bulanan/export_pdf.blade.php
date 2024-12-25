<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style type="text/css">
        .table,
        .table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            border: 3px solid black;
            font-size: 18px;
        }
        .table-2 {
            border-collapse: collapse;
            border-spacing: 2;
            width: 100%;
            border: solid 2px black;
        }

        .table th,
        .table td {
            border: 1.5px solid black;
            font-size: 12px;
            border-collapse: collapse;
        }

        div.a {
            text-align: center;
        }

        .table_hei {
            /* height: 15px;
             */
            margin-bottom: 10px
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

    @php
    $chartConfig = '{
    "type": "pie",
    "data": {
    "labels": [2012, 2013, 2014, 2015, 2016],
    "datasets": [{
    "data": [120, 60, 50, 180, 120]
    }]
    },
    }';
    $chartUrl = 'https://quickchart.io/chart?w=500&h=200&c=' . urlencode($chartConfig);
    @endphp

    <!-- <table style="width:100%;">
        <tr>
            <td align="center">
                <img style="width: 70%; text-align: center" src="{{$chartUrl}}">
            </td>
        </tr>
    </table> -->


    <table style="width:100%; height:100%" class="table" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">
        <tr>
            <td rowspan="2">Periode</td>
            <td colspan="5">Jumlah Tiket By Status</td>
            <td rowspan="2">Total</td>
            <td rowspan="2">Violated</td>
            <td rowspan="2">Achieved</td>
        </tr>
        <tr>
            <td>Open</td>
            <td>On Hold</td>
            <td>Progress</td>
            <td>Done</td>
            <td>Closed</td>
        </tr>
        @foreach($tb_1 as $data_1)
        <tr>
            <td>{{$data_1['periode']}}</td>
            <td>{{$data_1['jumlah_status_open']}}</td>
            <td>{{$data_1['jumlah_status_onhold']}}</td>
            <td>{{$data_1['jumlah_status_progress']}}</td>
            <td>{{$data_1['jumlah_status_done']}}</td>
            <td>{{$data_1['jumlah_status_closed']}}</td>
            <td>{{$data_1['jumlah_status_open'] + 
                $data_1['jumlah_status_progress'] + 
                $data_1['jumlah_status_done'] + 
                $data_1['jumlah_status_onhold'] + 
                $data_1['jumlah_status_closed']}}</td>
            <td>{{$data_1['jumlah_status_done_tidak_sesuai_sla']}}</td>
            <td>{{ ($data_1['jumlah_status_done'] + $data_1['jumlah_status_closed']) - $data_1['jumlah_status_done_tidak_sesuai_sla'] }}</td>
        </tr>

        @endforeach

        @php
        $jumlah_status_open_plus_plus = 0;
        $jumlah_status_progress_plus_plus = 0;
        $jumlah_status_done_plus_plus = 0;
        $jumlah_status_onhold_plus_plus = 0;
        $jumlah_status_closed_plus_plus = 0;
        $jumlah_total_semua_status = 0;

        $jumlah_status_done_tidak_sesuai_sla_plus_plus = 0;
        $jumlah_status_done_sesuai_sla_plus_plus = 0;

        $req_count = 0;
        $inc_count = 0;
        

        @endphp

        @foreach($tb_1_1 as $data_1_1 => $value)
        <tr>
            <td style="text-align: center; background-color: blue; color: white" colspan="9"> TOTAL {{$value}}</td>
        </tr>
        
        @foreach($tb_1 as $data_1)
        @php
        if($value == substr($data_1['periode'],0, 4)){
        @endphp
        <tr>
            <td>{{$data_1['periode']}}</td>
            <td>{{$data_1['jumlah_status_open'] + $jumlah_status_open_plus_plus}}</td>
            <td>{{$data_1['jumlah_status_onhold'] + $jumlah_status_onhold_plus_plus}}</td>
            <td>{{$data_1['jumlah_status_progress'] + $jumlah_status_progress_plus_plus}}</td>
            <td>{{$data_1['jumlah_status_done'] + $jumlah_status_done_plus_plus}}</td>
            <td>{{$data_1['jumlah_status_closed'] + $jumlah_status_closed_plus_plus}}</td>
            <td>{{$data_1['jumlah_status_open'] + 
                $data_1['jumlah_status_progress'] + 
                $data_1['jumlah_status_done'] + 
                $data_1['jumlah_status_onhold'] +
                $data_1['jumlah_status_closed'] + 
                $jumlah_total_semua_status}}</td>
            <td>{{$data_1['jumlah_status_done_tidak_sesuai_sla']}}</td>
            <td>{{$data_1['jumlah_status_done_sesuai_sla']}}</td>
        </tr>

        @php
        $jumlah_status_open_plus_plus = $data_1['jumlah_status_open'] + $jumlah_status_open_plus_plus;
        $jumlah_status_progress_plus_plus = $data_1['jumlah_status_progress'] + $jumlah_status_progress_plus_plus;
        $jumlah_status_done_plus_plus = $data_1['jumlah_status_done'] + $jumlah_status_done_plus_plus;
        $jumlah_status_onhold_plus_plus = $data_1['jumlah_status_onhold'] + $jumlah_status_onhold_plus_plus;
        $jumlah_status_closed_plus_plus = $data_1['jumlah_status_closed'] + $jumlah_status_closed_plus_plus;
        $jumlah_total_semua_status = $data_1['jumlah_status_open'] + $data_1['jumlah_status_progress'] + $data_1['jumlah_status_done'] + $data_1['jumlah_status_onhold'] + $data_1['jumlah_status_closed'] + $jumlah_total_semua_status;
        
        $jumlah_status_done_tidak_sesuai_sla_plus_plus = $data_1['jumlah_status_done_tidak_sesuai_sla'] + $jumlah_status_done_tidak_sesuai_sla_plus_plus;
        $jumlah_status_done_sesuai_sla_plus_plus = ( ( $data_1['jumlah_status_done'] + $data_1['jumlah_status_closed'] ) - $data_1['jumlah_status_done_tidak_sesuai_sla'] ) + $jumlah_status_done_sesuai_sla_plus_plus;
        
        @endphp

        @php
        }
        @endphp

        @endforeach

        @endforeach

    </table>



    @foreach($tb_1_1 as $data_1_1 => $value)
    <br>
    <table style="width:100%; height:100%" class="table" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">
        <tr>
            <td style="width:28%;">{{$value}}</td>
            <td style="width:6%;">Jan</td>
            <td style="width:6%;">Feb</td>
            <td style="width:6%;">Mar</td>
            <td style="width:6%;">Apr</td>
            <td style="width:6%;">Mei</td>
            <td style="width:6%;">Jun</td>
            <td style="width:6%;">Juli</td>
            <td style="width:6%;">Agust</td>
            <td style="width:6%;">Sep</td>
            <td style="width:6%;">Okt</td>
            <td style="width:6%;">Nov</td>
            <td style="width:6%;">Des</td>
        </tr>
        <tr>
            <td>Tingkat penyelesaian (%)</td>
            @foreach($tb_2 as $data_2 => $value_2)
            @php
            if($data_2 == $value){
            @endphp
            <td>{{$value_2[0]}}</td>
            <td>{{$value_2[1]}}</td>
            <td>{{$value_2[2]}}</td>
            <td>{{$value_2[3]}}</td>
            <td>{{$value_2[4]}}</td>
            <td>{{$value_2[5]}}</td>
            <td>{{$value_2[6]}}</td>
            <td>{{$value_2[7]}}</td>
            <td>{{$value_2[8]}}</td>
            <td>{{$value_2[9]}}</td>
            <td>{{$value_2[10]}}</td>
            <td>{{$value_2[11]}}</td>
            @php
            }
            @endphp
            @endforeach
        </tr>
        <tr>
        <td>Tingkat penyelesaian Sesuai SLA (%)</td>
            @foreach($tb_2 as $data_2 => $value_2)
            @php
            if($data_2 == $value){
            @endphp
            <td>{{$value_2[12]}}</td>
            <td>{{$value_2[13]}}</td>
            <td>{{$value_2[14]}}</td>
            <td>{{$value_2[15]}}</td>
            <td>{{$value_2[16]}}</td>
            <td>{{$value_2[17]}}</td>
            <td>{{$value_2[18]}}</td>
            <td>{{$value_2[19]}}</td>
            <td>{{$value_2[20]}}</td>
            <td>{{$value_2[21]}}</td>
            <td>{{$value_2[22]}}</td>
            <td>{{$value_2[23]}}</td>
            @php
            }
            @endphp
            @endforeach
        </tr>
    </table>
    @endforeach

    @foreach($periode as $dt_periode_1 => $val_periode_1)
    <br>
    <table style="width:100%; height:100%" class="table" style="font-family: Arial, Helvetica, sans-serif; text-align: center;">
        <tr>
            <td rowspan="3">No</td>
            <td rowspan="3">Jenis Layanan / Subject</td>
            <td colspan="7">Status Layanan</td>
            <!-- <td><td> -->
        </tr>
        <tr>
            <!-- <td></td> -->
            <!-- <td></td> -->
            <td colspan="6">{{$dt_periode_1}}</td>
            <!-- <td><td> -->
            <td rowspan="2">
                Penyelesaian
            </td>
        </tr>
        <tr>
            <!-- <td>
                No
            </td> -->
            <!-- <td>
                Jenis Layanan / Subject
            </td> -->
            <td>
                Open
            </td>
            <td>
                On Hold
            </td>
            <td>
                Progress
            </td>
            <td>
                Done
            </td>
            <td>
                Closed
            </td>
            <td>
                Jml
            </td>
            <!-- <td>
                Penyelesaian
            </td> -->
        </tr>

        @php
            $semua_total_status_open = 0;
            $semua_total_status_progress = 0;
            $semua_total_status_done = 0;
            $semua_total_status_closed = 0;
            $semua_total_status_onhold = 0;
            $semua_total_jumlah = 0;
        @endphp

        @foreach($val_periode_1 as $dt_periode_2 => $val_periode_2)
        <tr>
            <td colspan="9" style="text-align: left;">{{$dt_periode_2}}</td>
        </tr>
        @php
            $no_periode_3 = 1;
            $sub_total_status_open = 0;
            $sub_total_status_progress = 0;
            $sub_total_status_done = 0;
            $sub_total_status_closed = 0;
            $sub_total_status_onhold = 0;
            $sub_total_jumlah = 0;
        @endphp

        @foreach($val_periode_2 as $dt_periode_3 => $val_periode_3)
        
        @php
        $semua_total_status_open += $val_periode_3['status_open'];
        $semua_total_status_progress += $val_periode_3['status_progress'];
        $semua_total_status_done += $val_periode_3['status_done'];
        $semua_total_status_closed += $val_periode_3['status_closed'];
        $semua_total_status_onhold += $val_periode_3['status_onhold'];
        $semua_total_jumlah += $val_periode_3['status_open'] + $val_periode_3['status_progress'] + $val_periode_3['status_done'] + $val_periode_3['status_closed'] + $val_periode_3['status_onhold'];

        @endphp

        @php
        $sub_total_status_open += $val_periode_3['status_open'];
        $sub_total_status_progress += $val_periode_3['status_progress'];
        $sub_total_status_done += $val_periode_3['status_done'];
        $sub_total_status_closed += $val_periode_3['status_closed'];
        $sub_total_status_onhold += $val_periode_3['status_onhold'];
        $sub_total_jumlah += $val_periode_3['status_open'] + $val_periode_3['status_progress'] + $val_periode_3['status_done'] + $val_periode_3['status_closed'] + $val_periode_3['status_onhold'];
        if (strpos($dt_periode_3, 'REQ') !== false) {
            $req_count += $val_periode_3['status_open'] + $val_periode_3['status_progress'] + $val_periode_3['status_done'] + $val_periode_3['status_closed'] + $val_periode_3['status_onhold'];
        }
        if (strpos($dt_periode_3, 'INC') !== false) {
            $inc_count += $val_periode_3['status_open'] + $val_periode_3['status_progress'] + $val_periode_3['status_done'] + $val_periode_3['status_closed'] + $val_periode_3['status_onhold'];
        }
        @endphp

        <tr>
            <td>{{$no_periode_3++}}</td>
            <td style="text-align: left;">{{$dt_periode_3}}</td>

            <td style="text-align: center;">{{$val_periode_3['status_open']}}</td>
            <td style="text-align: center;">{{$val_periode_3['status_onhold']}}</td>
            <td style="text-align: center;">{{$val_periode_3['status_progress']}}</td>
            <td style="text-align: center;">{{$val_periode_3['status_done']}}</td>
            <td style="text-align: center;">{{$val_periode_3['status_closed']}}</td>
            <td style="text-align: center;">{{$val_periode_3['status_open'] + $val_periode_3['status_progress'] + $val_periode_3['status_done'] + $val_periode_3['status_closed'] + $val_periode_3['status_onhold']}}</td>

            <td style="text-align: center;">-</td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td style="text-align: left;">Sub-Total</td>

            <td style="text-align: center;">{{$sub_total_status_open}}</td>
            <td style="text-align: center;">{{$sub_total_status_onhold}}</td>
            <td style="text-align: center;">{{$sub_total_status_progress}}</td>
            <td style="text-align: center;">{{$sub_total_status_done}}</td>
            <td style="text-align: center;">{{$sub_total_status_closed}}</td>
            <td style="text-align: center;">{{$sub_total_jumlah}}</td>

            <td style="text-align: center;">
                <?php
                if ($sub_total_jumlah == 0) {
                    echo '-';
                } else {
                    echo round(($sub_total_status_closed + $sub_total_status_done) / $sub_total_jumlah * 100, 2) . '%';
                }
                ?>
            </td>
        </tr>
        @endforeach

        <tr>
            <td></td>
            <td style="text-align: center;">Total Keseluruhan</td>

            @foreach($tb_1 as $tb_11111)
            @if($dt_periode_1 == $tb_11111['periode'])

            <td>{{$tb_11111['jumlah_status_open']}}</td>
            <td>{{$tb_11111['jumlah_status_onhold']}}</td>
            <td>{{$tb_11111['jumlah_status_progress']}}</td>
            <td>{{$tb_11111['jumlah_status_done']}}</td>
            <td>{{$tb_11111['jumlah_status_closed']}}</td>
            <td>{{$tb_11111['jumlah_status_open'] + 
                $tb_11111['jumlah_status_progress'] + 
                $tb_11111['jumlah_status_done'] + 
                $tb_11111['jumlah_status_onhold'] + 
                $tb_11111['jumlah_status_closed']}}
            </td>

            @endif
            @endforeach

            <td style="text-align: center;">
                <?php
                if ($semua_total_jumlah == 0) {
                    echo '0%';
                } else {
                    // echo $semua_total_status_closed;
                    echo round(($semua_total_status_closed + $semua_total_status_done) / $semua_total_jumlah * 100, 2) . '%';
                }
                ?>
            </td>
        </tr>
        


    </table>

    @endforeach

    <table id="footer" style="font-family: Arial, Helvetica, sans-serif; text-align: center; width: 20%;">
        <tr>
            <td style="text-align: left;">Total REQ</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: left;">{{$req_count}}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Total INC</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: left;">{{$inc_count}}</td>
        </tr>
        <tr>
            <td style="text-align: left;">Jumlah Eskalasi PI</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: left;">{{$jumlah_eskalasi_pi}}</td>
        </tr>
    </table>
    
    
</body>

</html>