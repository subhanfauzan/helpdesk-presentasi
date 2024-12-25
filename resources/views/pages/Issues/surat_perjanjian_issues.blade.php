<?php
$hari_ini = date("Y-m-d");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Surat Perjanjian Issues</title>
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
    </style>
</head>

<body style="font-family: 'Serif'">
    <header>
        <table class="text-center" border="0" style="width: 100%;">
            <tr>
                <td style="width: 100%">
                    <p style="font-size:20pt;">SURAT PERNYATAAN ISU SELESAI</p>
                </td>
            </tr>
        </table>
    </header>

    <br>
    <br>
    <br>
    <br>

    <div style="width: 100%; float: left;">
        <table class="text-center" border="0" style="width: 100%;  font-size: 12pt; padding-bottom: 10px; padding-top: 10px">
            <tr>
                <td align="left" style="width: 45%">
                    Saya yang bertanda tangan dibawah ini
                </td>
                <td align="left" style="width: 2%">

                </td>
                <td align="left" style="width: 53%">

                </td>
            </tr>
            <tr>
                <td align="left" style="width: 45%">
                    Nama
                </td>
                <td align="left" style="width: 2%">
                    :
                </td>
                <td align="left" style="width: 53%">
                    {{$nama}}
                </td>
            </tr>
            <tr>
                <td align="left" style="width: 45%">
                    Username
                </td>
                <td align="left" style="width: 2%">
                    :
                </td>
                <td align="left" style="width: 53%">
                    {{$username}}
                </td>
            </tr>
            <tr>
                <td align="left" style="width: 45%">
                    NIK
                </td>
                <td align="left" style="width: 2%">
                    :
                </td>
                <td align="left" style="width: 53%">
                    {{$username}}
                </td>
            </tr>
            <tr>
                <td style="text-align: justify;" colspan="3">
                    Dengan ini saya menyatakan sepakat untuk menyetujui persyaratan sebagai berikut :
                </td>
            </tr>
            <tr>
                <td style="text-align: justify;" colspan="3">
                    <table>
                        <tr>
                            <td style="width: 3%">

                            </td>
                            <td style="width: 2%; vertical-align: top; text-align: left;">
                                1.
                            </td>
                            <td style="width: 95%">
                                Saya tidak akan mengganti / menambah isu setelah isu sudah diselesaikan
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: justify;" colspan="3">
                    <table>
                        <tr>
                            <td style="width: 3%">

                            </td>
                            <td style="width: 2%; vertical-align: top; text-align: left;">
                                2.
                            </td>
                            <td style="width: 95%">
                                Saya bersedia bertanggung jawab atas diselesaikannya issue dengan tiket issue ( {{$tiket_issues}} )
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
            <tr>
                <td style="text-align: justify;" colspan="3">
                    Demikian surat pernyataan diri ini saya buat dan saya setujui dengan sebenar-benarnya, dengan sadar dan tanpa paksaan dari pihak manapun.
                </td>
            </tr>
            <tr>
                <td style="text-align: justify;" colspan="3">
                    Dibawah ini adalah tanda tangan saya dalam format digital yang SAH.
                </td>
            </tr>
            <tr>
                <td style="text-align: justify;" colspan="3">
                    Saya bersedia menerima konsekuensi hukum, jika pernyataan diri ini dikemudian hari terdapat kesalahan atau kebohongan.
                </td>
            </tr>
        </table>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <table style="width: 100%">
        <tr>
            <td style="width: 10%">

            </td>
            <td style="width: 40%; vertical-align: top; text-align: left; font-size: 14pt;">
                Petrokimia Gresik, {{date('d-m-Y')}}
                <br>
                <br>
            </td>

            <td style="width: 40%; vertical-align: top; text-align: right; font-size: 14pt;">
                Petrokimia Gresik, {{date('d-m-Y')}}
                <br>
                <br>
            </td>

            <td style="width: 10%">

            </td>
        </tr>

        <tr>
            <td style="width: 2%">

            </td>
            <td style="width: 48%; vertical-align: top; text-align: left; font-size: 14pt;">
                <!-- <img src='{{ public_path("image/ttd_contoh.png") }}' style="width: 100px;"> -->
                @if($tanda_tangan == null || $tanda_tangan=="")
                ( Anda Belum Menginputkan TTD Requester )
                @else
                <img id="sig-image" src="{{$tanda_tangan}}" style="width: 200px; height: 120px" />
                @endif

            </td>


            <td style="width: 48%; vertical-align: top; text-align: right; font-size: 14pt;">
                <!-- <img src='{{ public_path("image/ttd_contoh.png") }}' style="width: 100px;"> -->
                @if($tanda_tangan_2 == null || $tanda_tangan_2=="")
                ( Anda Belum Menginputkan TTD Staff TI )
                @else
                <img id="sig-image" src="{{$tanda_tangan_2}}" style="width: 200px; height: 120px" />
                @endif

            </td>

            <td style="width: 2%">

            </td>
        </tr>
        <tr>
            <td style="width: 2%">

            </td>
            <td style="width: 48%; vertical-align: top; text-align: left; font-size: 14pt;">
                @if($tanda_tangan_atas_nama == null || $tanda_tangan_atas_nama=="")
                <h5>( Anda Belum Menginputkan Nama Requester )</h5>
                @else
                {{$tanda_tangan_atas_nama}}
                @endif
                <br>
                ( Requester )

            </td>


            <td style="width: 48%; vertical-align: top; text-align: right; font-size: 14pt;">
                @if($tanda_tangan_2_atas_nama == null || $tanda_tangan_2_atas_nama=="")
                <h5>( Anda Belum Menginputkan Nama Staff TI )</h5>
                @else
                {{$tanda_tangan_2_atas_nama}}
                @endif
                <br>
                ( Staff TI )
            </td>

            <td style="width: 2%">

            </td>
        </tr>
    </table>


</body>

</html>

<!-- <script>

  window.print();

</script> -->