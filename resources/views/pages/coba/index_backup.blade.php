@extends('layouts.app')

@section('content')



<div class="page">
    <div class="page-content container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <!-- First Row -->
            <!-- Completed Options Pie Widgets -->
            <div class="col-xxl-3">
                <div class="row h-full" data-plugin="matchHeight">
                    <div class="col-xxl-12 col-lg-4 col-sm-4">
                        <div class="card card-shadow card-completed-options">
                            <div class="card-block p-30">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="counter text-left blue-grey-700">
                                            <div class="counter-label mt-10">Tasks Completed
                                            </div>
                                            <div class="counter-number font-size-40 mt-10">
                                                1,234
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="pie-progress pie-progress-sm" data-plugin="pieProgress" data-valuemax="100" data-barcolor="#57c7d4" data-size="100" data-barsize="10" data-goal="86" aria-valuenow="86" role="progressbar">
                                            <span class="pie-progress-number blue-grey-700 font-size-20">
                                                86%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-lg-4 col-sm-4">
                        <div class="card card-shadow card-completed-options">
                            <div class="card-block p-30">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="counter text-left blue-grey-700">
                                            <div class="counter-label mt-10">Points Completed
                                            </div>
                                            <div class="counter-number font-size-40 mt-10">
                                                698
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="pie-progress pie-progress-sm" data-plugin="pieProgress" data-valuemax="100" data-barcolor="#62a8ea" data-size="100" data-barsize="10" data-goal="62" aria-valuenow="62" role="progressbar">
                                            <span class="pie-progress-number blue-grey-700 font-size-20">
                                                62%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-lg-4 col-sm-4">
                        <div class="card card-shadow card-completed-options">
                            <div class="card-block p-30">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="counter text-left blue-grey-700">
                                            <div class="counter-label mt-10">Cards Completed
                                            </div>
                                            <div class="counter-number font-size-40 mt-10">
                                                1,358
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="pie-progress pie-progress-sm" data-plugin="pieProgress" data-valuemax="100" data-barcolor="#926dde" data-size="100" data-barsize="10" data-goal="56" aria-valuenow="56" role="progressbar">
                                            <span class="pie-progress-number blue-grey-700 font-size-20">
                                                56%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Completed Options Pie Widgets -->
            <!-- Team Total Completed -->
            <div class="col-xxl-9">
                <div id="teamCompletedWidget" class="card card-shadow example-responsive">
                    <div class="card-block p-20 pb-25">
                        <div class="row pb-40" data-plugin="matchHeight">
                            <div class="col-md-6">
                                <div class="counter text-left pl-10">
                                    <div class="counter-label">Team Total Completed</div>
                                    <div class="counter-number-group text-truncate">
                                        <span>1,439</span>
                                        <span>86%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-inline mr-50">
                                    <li class="list-inline-item">
                                        Task Completed
                                    </li>
                                    <li class="list-inline-item">
                                        Cards Completed
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="ct-chart"></div>
                    </div>
                </div>
            </div>
            <!-- End To Do List -->
            <!-- Recent Activity -->

        </div>
    </div>
</div>


@endsection