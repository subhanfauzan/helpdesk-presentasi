@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Home</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <!-- <div class="card"> -->
                                        <!-- <label class="form-label" for="full-name">Pilih Kategori :</label> -->
                                        <!-- <div class='tableauPlaceholder' id='viz1534262301264' style='position: relative'>
                                            <object class='tableauViz' width='1326' height='538' style='display:none;'>
                                                <param name='host_url' value='{{ $setting_data["host_url"] }}trusted/{{$tickets}}/' />
                                                <param name='embed_code_version' value='3' />
                                                <param name='site_root' value='' />
                                                <param name='name' value='{{$isimenu}}' />
                                                <param name='tabs' value='no' />
                                                <param name='toolbar' value='no' />
                                                <param name='showAppBanner' value='false' />
                                                <param name='filter' value='iframeSizedToWindow=true' />
                                            </object>
                                        </div> -->
                                        <!-- <iframe style="width: 100%; height: 926px;"src="https://sips.petrokimia-gresik.com/login" title="description"></iframe> -->

                                        <div class="form-control-wrap">
                                            <!-- <input type="text" name="telp_issues" id="telp_issues" class="form-control" placeholder="Enter First Name"> -->
                                        </div>

                                        <div class="row g-3 align-items-center">
                                            <!-- <div class="col-1">
                                                    <label for="inputPassword6" class="col-form-label">Search : </label>
                                                </div> -->
                                            <div class="col-md-4">
                                                <select name="kategori_search" id="kategori_search" style="width: 100%">
                                                    <option value=""></option>
                                                    <option selected value="bulan"> Bulan</option>
                                                    <option value="hari"> Hari</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 tanggal_search_div">
                                                <input style="display: none;" type="text" name="tanggal_search_hari" id="tanggal_search_hari" class="form-control tanggal_search_hari" placeholder="Pilih Tanggal">
                                                <input type="text" name="tanggal_search_bulan" id="tanggal_search_bulan" class="form-control tanggal_search_bulan" placeholder="Pilih Tanggal">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h6 id="text"></h6>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card" id="chartDiv">
                                            <canvas id="myChart"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card" id="chartDiv2">
                                            <canvas style="margin-bottom: 10px" id="myChart2"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card" id="chartDiv3">
                                            <canvas id="myChart3"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card" id="chartDiv4">
                                            <h6 style="text-align: center">Jumlah Issue Per Kategori</h6>
                                            <canvas style="margin-bottom: 10px" id="myChart4"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card" id="chartDiv5">
                                            <canvas id="myChart5"></canvas>
                                        </div>
                                    </div>

                                    <div class="col-md-4" style="height: 415px; overflow-y: scroll;">
                                        <div class="card" id="chartDiv6">
                                            <h6 style="text-align: center">Jumlah Issue Per Subject</h6>
                                            <table class="table" id="tb_subject" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Subject</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div style="height: 300px" class="card" id="chartDiv7">
                                            <h6 style="text-align: center">SLA Issue Per Bulanan</h6>
                                            <canvas id="myChart7"></canvas>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
</div>
@endsection

@section('script')

<script>
    // $(document).ready(function() {
    //     var divElement = document.getElementById('viz1534262301264');
    //     var vizElement = divElement.getElementsByTagName('object')[0];
    //     vizElement.style.width = '100%';
    //     vizElement.style.height = '800px';
    //     var scriptElement = document.createElement('script');
    //     scriptElement.src = 'http://34.101.253.69/javascripts/api/viz_v1.js';
    //     vizElement.parentNode.insertBefore(scriptElement, vizElement);

    //     // resize detect js
    //     if (window.innerWidth > 1900) {
    //         var divElement = document.getElementById('viz1534262301264');
    //         var vizElement = divElement.getElementsByTagName('object')[0];
    //         vizElement.style.width = '100%';
    //         vizElement.style.height = '926px';
    //         // ------
    //         var el = document.getElementById('viz1534262301264');
    //         el.classList.add('screensize');
    //         var el = document.getElementsByTagName('body');
    //         el.classList.add('screensizeBody');
    //     }
    // });
</script>

<script>
    var tanggal_search_val = moment(new Date()).format("YYYY-MM");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ url('home/getIssuesPerBulan') }}" + '/' + 'bulan' + '/' + tanggal_search_val,
        type: "GET",
        dataType: 'json',
        success: function(datas) {
            // console.log('awal00');
            // console.log(datas);
            // console.log(datas.data_issues);
            // console.log(datas.label);
            // console.log(datas.kode);
            // console.log(datas.data_tanggal);
            // console.log(datas.tanggal_search_val);
            if (datas.kode == 201) {
                var text = "<p class='count'>Jumlah Issue pada Bulan " + datas.bulan + ": " + datas.jumlah + "</p>";
                $('p.count').remove();
                $('#text').append(text);

                // console.log('coba 1');
                // console.log(datas.sumbu_y);

                var i = 1;
                const sumbu_x = [];

                for (i; i <= datas.sumbu_x; i++) {
                    sumbu_x.push(i);
                }

                // console.log(sumbu_x);

                const data = {
                    labels: sumbu_x,
                    datasets: [{
                        label: 'Data Isu pada ' + tanggal_search_val,
                        backgroundColor: 'rgb(229, 153, 67)',
                        borderColor: 'rgb(229, 153, 67)',
                        data: datas.sumbu_y,
                        datalabels: {
                            align: 'start',
                            // anchor: 'end',
                            offset: -20,
                            color: '#000000',
                        }
                    }]
                };

                const config = {
                    plugins: [ChartDataLabels],
                    type: 'line',
                    data: data,
                    options: {
                        plugins: {
                            title: {
                                display: true,
                                text: 'Grafik Isu Harian',
                                font: {
                                    size: 20
                                }
                            },
                            datalabels: {
                                formatter: function(value, context) {
                                    if (value == 0) {
                                        return ``;
                                    } else {
                                        return `${value}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                suggestedMin: 1,
                                // suggestedMax: 100
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Isu'
                                }
                            },
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                }
                            }
                        }
                    }
                };

                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );

            }
        },
        error: function(data) {
            console.log('Error:', data);
            //$('#modalPenghargaan').modal('show');
        }
    });
</script>

<script>
    $(document).ready(function() {
        $("#kategori_search").select2({
            theme: "bootstrap-5",
            placeholder: "Pilih Kategori",
        });

        $('#kategori_search').on('select2:select', function(e) {

            var data_id = $("#kategori_search option:selected").val();

            if (data_id == 'bulan') {
                $(".tanggal_search_hari").css("display", "none");
                $(".tanggal_search_bulan").css("display", "block");

                $(".tanggal_search_hari").val("");
                $(".tanggal_search_bulan").val("");
            } else if (data_id == 'hari') {
                $(".tanggal_search_hari").css("display", "block");
                $(".tanggal_search_bulan").css("display", "none");

                $(".tanggal_search_hari").val("");
                $(".tanggal_search_bulan").val("");
            }

        });

        $('#tanggal_search_hari').datepicker({
            format: "yyyy-mm-dd"
        }).on('change', function() {

            var tanggal_search_val = $('#tanggal_search_hari').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getIssuesPerBulan') }}" + '/' + 'hari' + '/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    // console.log(datas);
                    // console.log(datas.data_issues);
                    // console.log(datas.label);
                    // console.log(datas.kode);
                    // console.log(datas.data_tanggal);
                    // console.log(datas.tanggal_search_val);
                    if (datas.kode == 201) {
                        var text = "<p class='count'>Jumlah Issue pada Bulan " + datas.bulan + ": " + datas.jumlah + "</p>";
                        $('p.count').remove();
                        $('#text').append(text);
                        // myChart.destroy();

                        // console.log(datas.sumbu_x);

                        const data = {
                            labels: datas.sumbu_x,
                            datasets: [{
                                label: 'Data Isu pada ' +
                                    tanggal_search_val,
                                backgroundColor: 'rgb(229, 153, 67)',
                                borderColor: 'rgb(229, 153, 67)',
                                data: datas.sumbu_y,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -20,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'line',
                            data: data,
                            options: {
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Grafik Isu Harian',
                                        font: {
                                            size: 20
                                        }
                                    },
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        suggestedMin: 1,
                                        // suggestedMax: 100
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Jumlah Isu'
                                        }
                                    },
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Tanggal'
                                        }
                                    }
                                }
                            }
                        };

                        // myChart.destroy();
                        $('#myChart').remove();
                        $('#chartDiv').append('<canvas id="myChart"></canvas>');

                        const myChart = new Chart(
                            document.getElementById('myChart'),
                            config
                        );

                    } else {
                        // toastr.clear();
                        // toastr.error(data.success);
                        // Swal.fire('Deleted!', 'Gagal Di Delete.', 'error');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

            //Pie Chart
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getCountIssuesPerBulan') }}" + '/hari/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {

                        const datapie = datas.data;
                        const data = {
                            labels: [
                                'Open',
                                'Progress',
                                'Done',
                                'Closed',
                                'On Hold'
                            ],
                            datasets: [{
                                label: 'Sebaran Issue',
                                data: datapie,
                                backgroundColor: [
                                    'rgb(228,161,27)',
                                    'rgb(84,180,211)',
                                    'rgb(34,139,34)',
                                    'rgb(0, 0, 220)',
                                    'rgb(220, 76, 100)'
                                ],
                                hoverOffset: 10,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -20,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'pie',
                            data: data,
                            options: {
                                plugins: {
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        $('#myChart2').remove();
                        $('#chartDiv2').append('<canvas id="myChart2"></canvas>');

                        const myChart2 = new Chart(
                            document.getElementById('myChart2'),
                            config
                        );

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getJumlahIssueByLayananTop') }}" + '/' + 'hari' + '/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {

                        console.log(datas);

                        const datapie = datas.data_jumlah_per_issue;
                        const data = {
                            labels: datas.data_nama_per_issue,
                            datasets: [{
                                label: '10 Layanan Isu Terbanyak ' + tanggal_search_val,
                                data: datapie,
                                hoverOffset: 10,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -15,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'bar',
                            data,
                            options: {
                                indexAxis: 'y',
                                plugins: {
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        $('#myChart3').remove();
                        $('#chartDiv3').append('<canvas id="myChart3" style="margin-bottom: 25px"></canvas>');

                        const myChart3 = new Chart(
                            document.getElementById('myChart3'),
                            config
                        );

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getJumlahIssueByKategori') }}" + '/' + 'hari' + '/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {

                        console.log(datas);

                        const datapie = datas.data_jumlah_per_issue;
                        const data = {
                            labels: datas.data_nama_per_issue,
                            datasets: [{
                                label: 'Sebaran Issue',
                                data: datapie,
                                hoverOffset: 10,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -40,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'pie',
                            data: data,
                            options: {
                                plugins: {
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        $('#myChart4').remove();
                        $('#chartDiv4').append('<canvas id="myChart4" style="margin-bottom: 10px"></canvas>');

                        const myChart4 = new Chart(
                            document.getElementById('myChart4'),
                            config
                        );

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getJumlahIssueByLayanan') }}" + '/' + 'hari' + '/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {

                        console.log(datas);

                        const datapie = datas.data_jumlah_per_issue;
                        const data = {
                            labels: datas.data_nama_per_issue,
                            datasets: [{
                                label: 'Semua Layanan ' + tanggal_search_val,
                                data: datapie,
                                hoverOffset: 10,
                                fill: false,
                                tension: 0.1,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -20,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'line',
                            data: data,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        $('#myChart5').remove();
                        $('#chartDiv5').append('<canvas id="myChart5" style="margin-bottom: 10px"></canvas>');

                        const myChart5 = new Chart(
                            document.getElementById('myChart5'),
                            config
                        );

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

            $('#tb_subject').DataTable().destroy();

            var tb_subject = $('#tb_subject').DataTable({
                responsive: {
                    details: true
                },
                processing: true,
                serverSide: true,
                searching: true,
                paging: false,
                sDom: 'lrtip', // untuk hidden search box di datatable
                bInfo: false,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('home/getJumlahIssueBySubjectDatatable') }}" + '/' + 'hari' + '/' +
                        tanggal_search_val,
                    type: 'GET',
                },
                columns: [{
                        data: 'no',
                        name: 'no',
                        className: 'text-center'
                    },
                    {
                        data: 'nama_subject',
                        name: 'nama_subject',
                        // className: 'text-center'
                    },
                    {
                        data: 'count',
                        name: 'count',
                        // className: 'text-center'
                    }

                ]
            })

        });


        $('#tanggal_search_bulan').datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months"
        }).on('change', function() {
            var tanggal_search_val = $('#tanggal_search_bulan').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getIssuesPerBulan') }}" + '/' + 'bulan' + '/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {
                        var text = "<p class='count'>Jumlah Issue pada Bulan " + datas.bulan + ": " + datas.jumlah + "</p>";
                        $('p.count').remove();
                        $('#text').append(text);

                        var i = 1;
                        const sumbu_x = [];

                        for (i; i <= datas.sumbu_x; i++) {
                            sumbu_x.push(i);
                        }

                        const data = {
                            labels: sumbu_x,
                            datasets: [{
                                label: 'Data Isu pada ' +
                                    tanggal_search_val,
                                backgroundColor: 'rgb(229, 153, 67)',
                                borderColor: 'rgb(229, 153, 67)',
                                data: datas.sumbu_y,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -20,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'line',
                            data: data,
                            options: {
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Grafik Isu Harian',
                                        font: {
                                            size: 20
                                        }
                                    },
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        suggestedMin: 1,
                                        // suggestedMax: 100
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Jumlah Isu'
                                        }
                                    },
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Tanggal'
                                        }
                                    }
                                }
                            }
                        };

                        // myChart.destroy();
                        $('#myChart').remove();
                        $('#chartDiv').append('<canvas id="myChart"></canvas>');

                        const myChart = new Chart(
                            document.getElementById('myChart'),
                            config
                        );

                    } else {
                        // toastr.clear();
                        // toastr.error(data.success);
                        // Swal.fire('Deleted!', 'Gagal Di Delete.', 'error');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                    //$('#modalPenghargaan').modal('show');
                }
            });

            //Pie Chart
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getCountIssuesPerBulan') }}" + '/bulan/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {

                        const datapie = datas.data;
                        const data = {
                            labels: [
                                'Open',
                                'Progress',
                                'Done',
                                'Closed',
                                'On Hold'
                            ],
                            datasets: [{
                                label: 'Sebaran Issue',
                                data: datapie,
                                backgroundColor: [
                                    'rgb(228,161,27)',
                                    'rgb(84,180,211)',
                                    'rgb(34,139,34)',
                                    'rgb(0, 0, 220)',
                                    'rgb(220, 76, 100)'
                                ],
                                hoverOffset: 10,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -20,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'pie',
                            data: data,
                            options: {
                                plugins: {
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        $('#myChart2').remove();
                        $('#chartDiv2').append('<canvas id="myChart2"></canvas>');

                        const myChart2 = new Chart(
                            document.getElementById('myChart2'),
                            config
                        );

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getJumlahIssueByLayananTop') }}" + '/' + 'bulan' + '/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {

                        console.log(datas);

                        const datapie = datas.data_jumlah_per_issue;
                        const data = {
                            labels: datas.data_nama_per_issue,
                            datasets: [{
                                label: '10 Layanan Isu Terbanyak ' + tanggal_search_val,
                                data: datapie,
                                hoverOffset: 10,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -15,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'bar',
                            data,
                            options: {
                                indexAxis: 'y',
                                plugins: {
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        $('#myChart3').remove();
                        $('#chartDiv3').append('<canvas id="myChart3" style="margin-bottom: 25px"></canvas>');

                        const myChart3 = new Chart(
                            document.getElementById('myChart3'),
                            config
                        );

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getJumlahIssueByKategori') }}" + '/' + 'bulan' + '/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {

                        console.log(datas);

                        const datapie = datas.data_jumlah_per_issue;
                        const data = {
                            labels: datas.data_nama_per_issue,
                            datasets: [{
                                label: 'Sebaran Issue',
                                data: datapie,
                                hoverOffset: 10,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -40,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'pie',
                            data: data,
                            options: {
                                plugins: {
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        $('#myChart4').remove();
                        $('#chartDiv4').append('<canvas id="myChart4" style="margin-bottom: 10px"></canvas>');

                        const myChart4 = new Chart(
                            document.getElementById('myChart4'),
                            config
                        );

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data: $('#FormEditUser').serialize(),
                url: "{{ url('home/getJumlahIssueByLayanan') }}" + '/' + 'bulan' + '/' +
                    tanggal_search_val,
                type: "GET",
                dataType: 'json',
                success: function(datas) {
                    if (datas.kode == 201) {

                        console.log(datas);

                        const datapie = datas.data_jumlah_per_issue;
                        const data = {
                            labels: datas.data_nama_per_issue,
                            datasets: [{
                                label: 'Semua Layanan ' + tanggal_search_val,
                                data: datapie,
                                hoverOffset: 10,
                                fill: false,
                                tension: 0.1,
                                datalabels: {
                                    align: 'start',
                                    // anchor: 'end',
                                    offset: -20,
                                    color: '#000000',
                                }
                            }]
                        };

                        const config = {
                            plugins: [ChartDataLabels],
                            type: 'line',
                            data: data,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    datalabels: {
                                        formatter: function(value, context) {
                                            if (value == 0) {
                                                return ``;
                                            } else {
                                                return `${value}`;
                                            }
                                        }
                                    }
                                }
                            }
                        };

                        $('#myChart5').remove();
                        $('#chartDiv5').append('<canvas id="myChart5" style="margin-bottom: 10px"></canvas>');

                        const myChart5 = new Chart(
                            document.getElementById('myChart5'),
                            config
                        );

                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

            $('#tb_subject').DataTable().destroy();

            var tb_subject = $('#tb_subject').DataTable({
                responsive: {
                    details: true
                },
                processing: true,
                serverSide: true,
                searching: true,
                paging: false,
                sDom: 'lrtip', // untuk hidden search box di datatable
                bInfo: false,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ url('home/getJumlahIssueBySubjectDatatable') }}" + '/' + 'bulan' + '/' +
                        tanggal_search_val,
                    type: 'GET',
                },
                columns: [{
                        data: 'no',
                        name: 'no',
                        className: 'text-center'
                    },
                    {
                        data: 'nama_subject',
                        name: 'nama_subject',
                        // className: 'text-center'
                    },
                    {
                        data: 'count',
                        name: 'count',
                        // className: 'text-center'
                    }

                ]
            })


        });

    });
</script>

<script>
    $(document).ready(function() {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ url('home/getCountIssuesPerBulan') }}" + '/bulan/' +
                tanggal_search_val,
            type: "GET",
            dataType: 'json',
            success: function(datas) {
                if (datas.kode == 201) {

                    const datapie = datas.data;
                    console.log(datapie);
                    const data = {
                        labels: [
                            'Open',
                            'Progress',
                            'Done',
                            'Closed',
                            'On Hold'
                        ],
                        datasets: [{
                            label: 'Sebaran Issue',
                            data: datapie,
                            backgroundColor: [
                                'rgb(228,161,27)',
                                'rgb(84,180,211)',
                                'rgb(34,139,34)',
                                'rgb(0, 0, 220)',
                                'rgb(220, 76, 100)'
                            ],
                            hoverOffset: 10,
                            datalabels: {
                                align: 'start',
                                // anchor: 'end',
                                offset: -15,
                                color: '#000000',
                            }
                        }]
                    };

                    const config = {
                        plugins: [ChartDataLabels],
                        type: 'pie',
                        data: data,
                        options: {
                            plugins: {
                                datalabels: {
                                    formatter: function(value, context) {
                                        if (value == 0) {
                                            return ``;
                                        } else {
                                            return `${value}`;
                                        }
                                    }
                                }
                            }
                        }
                    };

                    const myChart = new Chart(
                        document.getElementById('myChart2'),
                        config
                    );

                }
            },
            error: function(datas) {
                console.log('Error:', datas);
            }
        })
    });
</script>

<script>
    //Pie Chart
    var tanggal_search_val = moment(new Date()).format("YYYY-MM");
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // data: $('#FormEditUser').serialize(),
        url: "{{ url('home/getJumlahIssueByLayananTop') }}" + '/' + 'bulan' + '/' +
            tanggal_search_val,
        type: "GET",
        dataType: 'json',
        success: function(datas) {
            if (datas.kode == 201) {

                console.log(datas);

                const datapie = datas.data_jumlah_per_issue;
                const data = {
                    labels: datas.data_nama_per_issue,
                    datasets: [{
                        label: '10 Layanan Isu Terbanyak ' + tanggal_search_val,
                        data: datapie,
                        hoverOffset: 10,
                        datalabels: {
                            align: 'start',
                            // anchor: 'end',
                            offset: -15,
                            color: '#000000',
                        }
                    }]
                };

                const config = {
                    plugins: [ChartDataLabels],
                    type: 'bar',
                    data,
                    options: {
                        indexAxis: 'y',
                        plugins: {
                            datalabels: {
                                formatter: function(value, context) {
                                    if (value == 0) {
                                        return ``;
                                    } else {
                                        return `${value}`;
                                    }
                                }
                            }
                        }
                    }
                };

                $('#myChart3').remove();
                $('#chartDiv3').append('<canvas id="myChart3" style="margin-bottom: 25px"></canvas>');

                const myChart3 = new Chart(
                    document.getElementById('myChart3'),
                    config
                );

            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
</script>

<script>
    //Pie Chart
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // data: $('#FormEditUser').serialize(),
        url: "{{ url('home/getJumlahIssueByKategori') }}" + '/' + 'bulan' + '/' +
            tanggal_search_val,
        type: "GET",
        dataType: 'json',
        success: function(datas) {
            if (datas.kode == 201) {

                console.log(datas);

                const datapie = datas.data_jumlah_per_issue;
                const data = {
                    labels: datas.data_nama_per_issue,
                    datasets: [{
                        label: 'Sebaran Issue',
                        data: datapie,
                        hoverOffset: 10,
                        datalabels: {
                            align: 'start',
                            // anchor: 'end',
                            offset: -40,
                            color: '#000000',
                        }
                    }]
                };

                const config = {
                    plugins: [ChartDataLabels],
                    type: 'pie',
                    data: data,
                    options: {
                        plugins: {
                            datalabels: {
                                formatter: function(value, context) {
                                    if (value == 0) {
                                        return ``;
                                    } else {
                                        return `${value}`;
                                    }
                                }
                            }
                        }
                    }
                };

                $('#myChart4').remove();
                $('#chartDiv4').append('<canvas id="myChart4" style="margin-bottom: 10px"></canvas>');

                const myChart4 = new Chart(
                    document.getElementById('myChart4'),
                    config
                );

            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
</script>


<script>
    //Pie Chart
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // data: $('#FormEditUser').serialize(),
        url: "{{ url('home/getJumlahIssueByLayanan') }}" + '/' + 'bulan' + '/' +
            tanggal_search_val,
        type: "GET",
        dataType: 'json',
        success: function(datas) {
            if (datas.kode == 201) {

                console.log(datas);

                const datapie = datas.data_jumlah_per_issue;
                const data = {
                    labels: datas.data_nama_per_issue,
                    datasets: [{
                        label: 'Semua Layanan ' + + tanggal_search_val,
                        data: datapie,
                        hoverOffset: 10,
                        fill: false,
                        tension: 0.1,
                        datalabels: {
                            align: 'start',
                            // anchor: 'end',
                            offset: -20,
                            color: '#000000',
                        }
                    }]
                };

                const config = {
                    plugins: [ChartDataLabels],
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            datalabels: {
                                formatter: function(value, context) {
                                    if (value == 0) {
                                        return ``;
                                    } else {
                                        return `${value}`;
                                    }
                                }
                            }
                        }
                    }
                };

                $('#myChart5').remove();
                $('#chartDiv5').append('<canvas id="myChart5" style="margin-bottom: 10px"></canvas>');

                const myChart5 = new Chart(
                    document.getElementById('myChart5'),
                    config
                );

            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
</script>

<script type="text/javascript">
    // var table_riwayat_kenaikan_pangkat = ;
    $(document).ready(function() {
        // NioApp.DataTable.init = function() {
        // NioApp.DataTable('#tb_user', {

        var tb_subject = $('#tb_subject').DataTable({
            responsive: {
                details: true
            },
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            sDom: 'lrtip', // untuk hidden search box di datatable
            bInfo: false,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('home/getJumlahIssueBySubjectDatatable') }}" + '/' + 'bulan' + '/' +
                    tanggal_search_val,
                type: 'GET',
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    className: 'text-center'
                },
                {
                    data: 'nama_subject',
                    name: 'nama_subject',
                    // className: 'text-center'
                },
                {
                    data: 'count',
                    name: 'count',
                    // className: 'text-center'
                }

            ]
        })
        // };
    });
</script>

<script>
    //Pie Chart
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // data: $('#FormEditUser').serialize(),
        url: "{{ url('home/getDataDashboardIssueBulanan') }}" + "?tahun=2024",
        type: "GET",
        dataType: 'json',
        success: function(datas) {
            if (datas.kode == 201) {

                const datapie = datas.data_jumlah_per_issue;
                const data = {
                    labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                    datasets: [{
                        label: 'Tingkat penyelesaian (%)',
                        data: [datas.data[0]['januari'], datas.data[0]['februari'], datas.data[0]['maret'], datas.data[0]['april'], datas.data[0]['mei'], datas.data[0]['juni'], datas.data[0]['juli'], datas.data[0]['agustus'], datas.data[0]['september'], datas.data[0]['oktober'], datas.data[0]['november'], datas.data[0]['desember']],
                        backgroundColor: "rgb(252,222,112)",
                        datalabels: {
                            align: 'start',
                            // anchor: 'end',
                            offset: -10,
                            color: '#000000',
                        }
                    }, {
                        label: 'Tingkat penyelesaian Sesuai SLA (%)',
                        data: [datas.data[1]['januari'], datas.data[1]['februari'], datas.data[1]['maret'], datas.data[1]['april'], datas.data[1]['mei'], datas.data[1]['juni'], datas.data[1]['juli'], datas.data[1]['agustus'], datas.data[1]['september'], datas.data[1]['oktober'], datas.data[1]['november'], datas.data[1]['desember']],
                        backgroundColor: "rgb(24,85,25)",
                        datalabels: {
                            align: 'start',
                            // anchor: 'end',
                            offset: -10,
                            color: '#FFFFF0',
                        }
                    }]
                };

                const config = {
                    plugins: [ChartDataLabels],
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            datalabels: {
                                // display: function(context) {
                                //     return context.dataset.data[context.dataIndex];
                                // }
                                formatter: function(value, context) {
                                    if (value == 0) {
                                        return ``;
                                    } else {
                                        return `${value}%`;
                                    }
                                },
                                font: {
                                    weight: '500000'
                                }
                            }
                        }
                    }
                };

                $('#myChart7').remove();
                $('#chartDiv7').append('<canvas id="myChart7" style="margin-bottom: 10px"></canvas>');

                const myChart7 = new Chart(
                    document.getElementById('myChart7'),
                    config
                );

            }
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
</script>

@endsection