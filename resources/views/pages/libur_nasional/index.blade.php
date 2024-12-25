@extends('layouts.app')

@section('content')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">National Holiday</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Panel</a></li>
                            <li class="breadcrumb-item active">National Holiday</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-xl-12">
                                        <!-- <div class="card"> -->
                                        <!-- <div class="card-body"> -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mt-4 mt-xl-0">
                                                    <div class="mb-3">
                                                        <!-- <label class="form-label" for="formrow-firstname-input">Attachment File :</label> -->
                                                        <div id='calendar'></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                        <!-- </div> -->
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


<div class="modal fade" id="modalTambahLiburNasional" data-bs-focus="false">
    <form action="javascript:;" class="form-validate is-alter formTambahLiburNasional" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-top modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Tambah Libur Nasional</h5>
                    </div>
                    &nbsp;
                    <div class="modal-title"></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">

                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mt-4 mt-xl-0">
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Tanggal :</label>
                                                    <input type="text" readonly name="tanggal_libur_nasional" id="tanggal_libur_nasional" class="form-control" placeholder="Enter First Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mt-4 mt-xl-0">
                                                <div class="mb-3">
                                                    <label class="form-label" for="formrow-firstname-input">Nama Libur Nasional :</label>
                                                    <input type="text" name="nama_libur_nasional" id="nama_libur_nasional" class="form-control" placeholder="Nama Libur Nasional">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <!-- <span class="sub-text">Modal Footer Text</span> -->
                    <!-- <button type="button" id="tambah" namme="tambah" class="btn btn-md btn-primary">Simpan</button> -->
                    <button type="submit" class="btn btn-md btn-primary">Simpan</button>
                    <!-- <button type="submit" class="btn bg-pink-a400 text-white mr-1"><i class="md md-floppy"></i> Simpan</button> -->
                </div>
            </div>
        </div>
    </form>
</div>


@endsection

@section('script')

<script>
    var calendar;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        // calendarEl.remove();
        var events = [];
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // data: $('#formTambahIssues').serialize(),
            url: "{{url('libur_nasional/getLiburNasional')}}",
            type: "GET",
            dataType: 'json',
            success: function(data) {

                // // console.log(data.data.length);

                for (var i = 0; i < data.data.length; i++) {
                    // console.log(data.data[i].nama_libur_nasional);
                    // json_text += "{" +
                    //     "title:" + "'" + data.data[i].nama_libur_nasional + "'" + "," +
                    //     "start:" + "'" + data.data[i].tgl_libur_nasional + "'" + "" +
                    //     "},"
                    events.push({
                        id: data.data[i].id,
                        title: data.data[i].nama_libur_nasional,
                        start: data.data[i].tgl_libur_nasional
                    }, );
                }

                // // // console.log('coba_events');
                // // console.log(events);

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    dayMaxEventRows: true,
                    views: {
                        timeGrid: {
                            dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
                        }
                    },
                    dateClick: function(info) {
                        // alert('Clicked on: ' + info.dateStr);
                        // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                        // alert('Current view: ' + info.view.type);
                        // change the day's background color just for fun
                        // info.dayEl.style.backgroundColor = 'red';
                        $('#modalTambahLiburNasional').modal('toggle');
                        $('#modalTambahLiburNasional').modal('show');
                        $("#tanggal_libur_nasional").val(info.dateStr);

                        // $('#calendar').fullCalendar('removeEventSource', events);
                        // $('#calendar').fullCalendar('addEventSource', events);
                        // $('#calendar').fullCalendar('refetchEvents');

                        // $('.formTambahLiburNasional').submit(function(event) {
                        //     var formData = new FormData(this);
                        //     // console.log(formData);

                        //     $.ajax({
                        //         headers: {
                        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        //         },
                        //         // contentType: 'multipart/form-data',
                        //         data: formData,
                        //         cache: false,
                        //         processData: false,
                        //         contentType: false,
                        //         url: "{{url('libur_nasional/tambah')}}",
                        //         type: "POST",
                        //         dataType: 'json',
                        //         success: function(data) {
                        //             // console.log(data);
                        //             // console.log(data.kode);
                        //             if (data.kode == 201) {
                        //                 toastr.clear();
                        //                 toastr.success(data.success);
                        //                 // document.location = "{{ url('/home/index') }}";
                        //                 // $("#modalFormTambahIssues").modal('hide');
                        //                 // $('#tb_issues').DataTable().ajax.reload(null, false);
                        //                 // $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                        //             } else {
                        //                 toastr.clear();
                        //                 toastr.error(data.success);
                        //             }

                        //         },
                        //         error: function(data) {
                        //             // console.log('Error:', data);
                        //             //$('#modalPenghargaan').modal('show');
                        //         }
                        //     });

                        // });

                        // var eventSources = calendar.getEventSources();
                        // var len = eventSources.length;
                        // for (var j = 0; j < len; j++) {
                        //     eventSources[j].remove();
                        // }
                        // calendar.addEventSource(events);


                    },
                    events: events,
                    eventClick: function(info) {
                        // console.log(info.event);
                        // // console.log(info.event._def.publicId);
                        // // console.log(info.event._def.extendedProps);
                        // // console.log(info.event._def.extendedProps.data);

                        var m_libur_nasional_id = info.event._def.publicId;
                        var title = info.event._def.title;

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Delete National Holiday " + title,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!'
                        }).then(function(result) {
                            if (result.value) {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    // data: $('#FormEditUser').serialize(),
                                    url: "{{url('libur_nasional/delete')}}" + '/' + m_libur_nasional_id,
                                    type: "GET",
                                    dataType: 'json',
                                    success: function(data) {
                                        // console.log(data);
                                        // console.log(data.kode);
                                        if (data.kode == 201) {
                                            toastr.clear();
                                            toastr.success(data.success);
                                            // document.location = "{{ url('/home/index') }}";
                                            // $("#modalFormEditUser").modal('hide');
                                            // Swal.fire('Deleted!', 'Berhasil Di Delete.', 'success');
                                            // $('#tb_kategori').DataTable().ajax.reload(null, false);
                                            var eventSources = calendar.getEventSources();
                                            // console.log(eventSources[0]);
                                            var len = eventSources.length;
                                            for (var i = 0; i < len; i++) {
                                                eventSources[i].remove();
                                            }

                                            //add events calendar
                                            var events = [];

                                            for (var i = 0; i < data.data.length; i++) {
                                                // console.log(data.data[i].nama_libur_nasional);
                                                // json_text += "{" +
                                                //     "title:" + "'" + data.data[i].nama_libur_nasional + "'" + "," +
                                                //     "start:" + "'" + data.data[i].tgl_libur_nasional + "'" + "" +
                                                //     "},"
                                                events.push({
                                                    id: data.data[i].id,
                                                    title: data.data[i].nama_libur_nasional,
                                                    start: data.data[i].tgl_libur_nasional
                                                }, );
                                            }


                                            calendar.addEventSource(events);
                                        } else {
                                            toastr.clear();
                                            toastr.error(data.success);
                                            // Swal.fire('Deleted!', 'Gagal Di Delete.', 'error');
                                        }
                                    },
                                    error: function(data) {
                                        // console.log('Error:', data);
                                        //$('#modalPenghargaan').modal('show');
                                    }
                                });

                            }
                        });

                    }
                });
                calendar.render();

            },
            error: function(data) {
                // console.log('Error:', data);
                //$('#modalPenghargaan').modal('show');
            }
        })


    });
</script>

<script>
    $('.formTambahLiburNasional').submit(function(event) {
        var formData = new FormData(this);
        // console.log(formData);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // contentType: 'multipart/form-data',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            url: "{{url('libur_nasional/tambah')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                // console.log(data.kode);

                //remove events calendar
                var eventSources = calendar.getEventSources();
                // console.log(eventSources[0]);
                var len = eventSources.length;
                for (var i = 0; i < len; i++) {
                    eventSources[i].remove();
                }

                //add events calendar
                var events = [];

                for (var i = 0; i < data.data.length; i++) {
                    // console.log(data.data[i].nama_libur_nasional);
                    // json_text += "{" +
                    //     "title:" + "'" + data.data[i].nama_libur_nasional + "'" + "," +
                    //     "start:" + "'" + data.data[i].tgl_libur_nasional + "'" + "" +
                    //     "},"
                    events.push({
                        id: data.data[i].id,
                        title: data.data[i].nama_libur_nasional,
                        start: data.data[i].tgl_libur_nasional
                    }, );
                }


                calendar.addEventSource(events);

                if (data.kode == 201) {
                    toastr.clear();
                    toastr.success(data.success);
                    // document.location = "{{ url('/home/index') }}";
                    $("#modalTambahLiburNasional").modal('hide');
                    // $('#tb_issues').DataTable().ajax.reload(null, false);
                    // $('#tb_issues_unit_kerja').DataTable().ajax.reload(null, false);
                } else {
                    toastr.clear();
                    toastr.error(data.success);
                }

            },
            error: function(data) {
                // console.log('Error:', data);
                //$('#modalPenghargaan').modal('show');
            }
        });


    });
</script>

@endsection