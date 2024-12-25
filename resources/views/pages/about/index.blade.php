@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <!-- <section id="knowledge-base-content">
            <div class="row kb-search-content-info match-height">
                <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                    <div class="card">
                        <a href="knowledge-base/category.html">
                            <img src="{{asset('public/image/sales.svg')}}" class="card-img-top" alt="knowledge-base-image" />

                            <div class="card-body text-center">
                                <h4>Sales Automation</h4>
                                <p class="text-body mt-1 mb-0">
                                    There is perhaps no better demonstration of the folly of image of our tiny world.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                    <div class="card">
                        <a href="knowledge-base/category.html">
                            <img src="{{asset('public/image/marketing.svg')}}" class="card-img-top" alt="knowledge-base-image" />
                            <div class="card-body text-center">
                                <h4>Marketing Automation</h4>
                                <p class="text-body mt-1 mb-0">
                                    Look again at that dot. That’s here. That’s home. That’s us. On it everyone you love.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                    <div class="card">
                        <a href="knowledge-base/category.html">
                            <img src="{{asset('public/image/api.svg')}}" class="card-img-top" alt="knowledge-base-image" />
                            <div class="card-body text-center">
                                <h4>API Questions</h4>
                                <p class="text-body mt-1 mb-0">every hero and coward, every creator and destroyer of civilization.</p>
                                <br>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                    <div class="card">
                        <a href="knowledge-base/category.html">
                            <img src="{{asset('public/image/personalization.svg')}}" class="card-img-top" alt="knowledge-base-image" />
                            <div class="card-body text-center">
                                <h4>Personalization</h4>
                                <p class="text-body mt-1 mb-0">It has been said that astronomy is a humbling and character experience.</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                    <div class="card">
                        <a href="knowledge-base/category.html">
                            <img src="{{asset('public/image/email.svg')}}" class="card-img-top" alt="knowledge-base-image" />
                            <div class="card-body text-center">
                                <h4>Email Marketing</h4>
                                <p class="text-body mt-1 mb-0">There is perhaps no better demonstration of the folly of human conceits.</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                    <div class="card">
                        <a href="knowledge-base/category.html">
                            <img src="{{asset('public/image/demand.svg')}}" class="card-img-top" alt="knowledge-base-image" />
                            <div class="card-body text-center">
                                <h4>Demand Generation</h4>
                                <p class="text-body mt-1 mb-0">Competent means we will never take anything for granted.</p>
                                <br>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section> -->


                    <section id="faq-tabs">
                        <!-- vertical tab pill -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="faq-navigation d-flex justify-content-between flex-column mb-2 mb-md-0">
                                    <!-- pill tabs navigation -->
                                    <ul class="nav nav-pills nav-left flex-column" role="tablist">
                                        <!-- menu -->
                                        <li class="nav-item">
                                            <a class="nav-link navi active" id="menu" data-bs-toggle="pill" href="#about-helpdesk" aria-expanded="true" role="tab">
                                                <i class="mdi mdi-help-box"></i>
                                                <span class="fw-bold">About Helpdesk</span>
                                            </a>
                                        </li>

                                        <!-- delivery -->
                                        <li class="nav-item">
                                            <a class="nav-link navi" id="delivery" data-bs-toggle="pill" href="#menu-delivery" aria-expanded="false" role="tab">
                                                <i class="mdi mdi-menu"></i>
                                                <span class="fw-bold">Menu Helpdesk</span>
                                            </a>
                                        </li>

                                        <!-- cancellation and return -->
                                        <li class="nav-item">
                                            <a class="nav-link navi" id="cancellation-return" data-bs-toggle="pill" href="#partner-app" aria-expanded="false" role="tab">
                                                <i class="mdi mdi-application"></i>
                                                <span class="fw-bold">Partner App</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <img src="{{asset('public/image/faq-illustrations.svg')}}" class="img-fluid d-none d-md-block" alt="demand img" />
                                </div>
                            </div>

                            <div class="col-lg-9 col-md-8 col-sm-12">
                                <!-- pill tabs tab content -->
                                <div class="tab-content">
                                    <!-- menu panel -->
                                    <div role="tabpanel" class="tab-pane active" id="about-helpdesk" aria-labelledby="menu" aria-expanded="true">
                                        <!-- icon and header -->
                                        <div class="d-flex align-items-center" style="margin-top: -17px; margin-left: -5px">
                                            <!-- <div class="avatar avatar-tag bg-light-primary me-1"> -->
                                            <i class="mdi mdi-help-box mdi-48px"></i>
                                            <!-- </div> -->
                                            <div style="margin-left: 10px; margin-top: -30px">
                                                <h4 style="margin-bottom: -1px;">About Helpdesk</h4>
                                                <span>Helpdesk</span>
                                            </div>
                                        </div>

                                        <!-- frequent answer and question  collapse  -->
                                        <div class="accordion accordion-margin mt-2" id="about-helpdesk-qna">
                                            <div class="card accordion-item">
                                                <h2 class="accordion-header" id="aboutTwo">
                                                    <button class="accordion-button" data-bs-toggle="collapse" role="button" data-bs-target="#about-helpdesk-two" aria-expanded="true" aria-controls="about-helpdesk-two">
                                                        Apa Itu Helpdesk V2 ?
                                                    </button>
                                                </h2>
                                                <div id="about-helpdesk-two" class="collapse show" aria-labelledby="aboutTwo" data-bs-parent="#about-helpdesk-qna">
                                                    <div class="accordion-body">
                                                        Aplikasi Helpdesk V2 adalah aplikasi untuk menampung issue
                                                        <!-- <div class="nk-content ">
                                                            <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                                                                <div class="brand-logo pb-1 text-center">
                                                                    <a href="html/index.html" class="logo-link">
                                                                    </a>
                                                                </div>
                                                                <form action="javascript:;" name="formLogin" id="formLogin" enctype="multipart/form-data">
                                                                    <div class="form-group">
                                                                        <div class="form-label-group">
                                                                            <label class="form-label" for="default-01">Username</label>
                                                                        </div>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Enter your email address or username">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="form-label-group">
                                                                            <label class="form-label" for="password">Password</label>
                                                                        </div>
                                                                        <div class="form-control-wrap">
                                                                            <a href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                                                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                            </a>
                                                                            <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Enter your passcode">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group mt-4">
                                                                        <button id="btnLogin" name="btnLogin" type="submit" class="btn btn-primary waves-effect waves-light"> Login </button>
                                                                        <button id="btnModalPencarianTiket" name="btnModalPencarianTiket" type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalPencarianTiket">Pencarian Tiket Isu</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- delivery panel -->
                                    <div class="tab-pane" id="menu-delivery" role="tabpanel" aria-labelledby="delivery" aria-expanded="false">
                                        <!-- icon and header -->
                                        <div class="d-flex align-items-center" style="margin-top: -17px; margin-left: -5px">
                                            <!-- <div class="avatar avatar-tag bg-light-primary me-1"> -->
                                            <i class="mdi mdi-menu mdi-48px"></i>
                                            <!-- </div> -->
                                            <div style="margin-left: 10px; margin-top: -30px">
                                                <h4 style="margin-bottom: -1px;">Menu Helpdesk</h4>
                                                <span>Helpdesk</span>
                                            </div>
                                        </div>

                                        <!-- frequent answer and question  collapse  -->
                                        <div class="accordion accordion-margin mt-2" id="menu-helpdesk-qna">
                                            <div class="card accordion-item">
                                                <h2 class="accordion-header" id="menuTwo">
                                                    <button class="accordion-button" data-bs-toggle="collapse" role="button" data-bs-target="#menu-helpdesk-two" aria-expanded="true" aria-controls="about-helpdesk-two">
                                                        Menu Home
                                                    </button>
                                                </h2>
                                                <div id="menu-helpdesk-two" class="collapse show" aria-labelledby="menuTwo" data-bs-parent="#menu-helpdesk-qna">
                                                    <div class="accordion-body">
                                                        Menu Home adalah menu yang menampilkan perihal data jumlah isu yang sudah dimasukan didalam aplikasi Helpdesk,
                                                        data tersebut ditampilkan dengan grafik garis ( line charts ) dan grafik lingkaran ( pie charts ).
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card accordion-item">
                                                <h2 class="accordion-header" id="menuThree">
                                                    <button class="accordion-button" data-bs-toggle="collapse" role="button" data-bs-target="#menu-helpdesk-three" aria-expanded="false" aria-controls="about-helpdesk-three">
                                                        Menu Issues
                                                    </button>
                                                </h2>
                                                <div id="menu-helpdesk-three" class="collapse" aria-labelledby="menuThree" data-bs-parent="#menu-helpdesk-qna">
                                                    <div class="accordion-body">
                                                        Menu Issues adalah menu untuk menambahkan isu dan menampilkan isu berdasarkan pegawai yang telah login.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- cancellation return  -->
                                    <div class="tab-pane" id="partner-app" role="tabpanel" aria-labelledby="cancellation-return" aria-expanded="false">
                                        <!-- icon and header -->
                                        <div class="d-flex align-items-center" style="margin-top: -17px; margin-left: -5px">
                                            <!-- <div class="avatar avatar-tag bg-light-primary me-1"> -->
                                            <i class="mdi mdi-application mdi-48px"></i>
                                            <!-- </div> -->
                                            <div style="margin-left: 10px; margin-top: -30px">
                                                <h4 style="margin-bottom: -1px;">Partner App</h4>
                                                <span>Helpdesk</span>
                                            </div>
                                        </div>

                                        <!-- frequent answer and question  collapse  -->
                                        <div class="accordion accordion-margin mt-2" id="partner-app-helpdesk-qna">
                                            <div class="card accordion-item">
                                                <h2 class="accordion-header" id="partnerAppTwo">
                                                    <button class="accordion-button" data-bs-toggle="collapse" role="button" data-bs-target="#partner-app-helpdesk-two" aria-expanded="true" aria-controls="about-helpdesk-two">
                                                        Partner App
                                                    </button>
                                                </h2>
                                                <div id="partner-app-helpdesk-two" class="collapse show" aria-labelledby="partnerAppTwo" data-bs-parent="#partner-app-helpdesk-qna">
                                                    <div class="accordion-body">

                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <img src="{{asset('public/image/simasti_logo.png')}}" class="card-img-top" alt="knowledge-base-image" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <img src="{{asset('public/image/logo_dof.jpeg')}}" class="card-img-top" alt="knowledge-base-image" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="faq-contact">
                        <div class="row pt-75" style="margin-top: -50px">
                            <div class="col-sm-6">
                                <div class="card text-center faq-contact-card shadow-none py-1">
                                    <div class="accordion-body">
                                        {{-- <div class="avatar avatar-tag bg-light-primary mb-2 mx-auto">
                                            <i data-feather="phone-call" class="font-medium-3"></i>
                                        </div> --}}
                                        <h4><a class="text-decoration-none text-dark" href="https://wa.me/62817776022" target="_blank"><i class='bx bxl-whatsapp'></i> + (62) 817 776022</a></h4>
                                        <span class="text-body">We are always happy to help!</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card text-center faq-contact-card shadow-none py-1">
                                    <div class="accordion-body">
                                        {{-- <div class="avatar avatar-tag bg-light-primary mb-2 mx-auto">
                                            <i data-feather="mail" class="font-medium-3"></i>
                                        </div> --}}
                                        <h4><i class='bx bx-phone-call' ></i> Ext 8888/2136</h4>
                                        <span class="text-body">Best way to get answer faster!</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection