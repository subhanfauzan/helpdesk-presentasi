@extends('layouts.app')

@section('content')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Kinerja Pegawai</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Laporan Kinerja</a></li>
                            <li class="breadcrumb-item active">Laporan Kinerja TI</li>
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
                                                    <!-- <h5 class="font-size-14 mb-4"><i class="mdi mdi-arrow-right text-primary me-1"></i> Form groups
                                                    </h5> -->
                                                    <iframe src="https://app.powerbi.com/view?r=eyJrIjoiYjY1MWE5ZmEtMjkzYy00ZTA3LTk3NWQtNDI3YWJiMWNlNDUyIiwidCI6ImE1NWFkM2Q0LTZkNjItNGVkZS1hOGM4LTBmMmMwMGQxYjhkZiIsImMiOjEwfQ%3D%3D&pageName=ReportSectiona7bf8e918e89b4b1da63" width="100%" height="700"></iframe>
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


@endsection

@section('script')

<script>



</script>

@endsection