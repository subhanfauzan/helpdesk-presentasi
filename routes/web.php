<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });



// Route::get('/login_index', 'loginController@index');
Route::get('/', 'loginController@index');
Route::get('/login', 'loginController@login');

Route::get('/getDetailDataIssues/{tiket_issues_duplikat}', 'loginController@getDetailDataIssues');

Route::get('/getListDataRiwayatStatusIssues/{tiket_issues}', 'loginController@getListDataRiwayatStatusIssues');

Route::get('/getDescriptionIssues/{tiket_issues}', 'loginController@getDescriptionIssues');

Route::get('/download_file/{file_name_dengan_extension}', 'loginController@download_file');

Route::get('/coba', 'cobaController@index');

Route::get('/getapilogin', 'pegawaiController@getapilogin');

Route::get('/getpegawai', 'pegawaiController@getpegawai');

Route::get('/getPegawaiTambahDatabase', 'pegawaiController@getPegawaiTambahDatabase');

Route::get('/getPerbaruiPegawai', 'pegawaiController@getPerbaruiPegawai');



Route::group(['prefix' => 'api'], function () {
    Route::get('/getIssuesTiketClient', 'apiIssuesController@getIssuesTiketClient');
    Route::get('/getIssuesTiketServer', 'apiIssuesController@getIssuesTiketServer');

    Route::get('/getListIssuesTiketClient', 'apiIssuesController@getListIssuesTiketClient');
    Route::get('/getListIssuesTiketServer', 'apiIssuesController@getListIssuesTiketServer');

    Route::get('/getStatusIssuesDoneClient', 'apiIssuesController@getStatusIssuesDoneClient');
    // Route::post('/postStatusIssuesDoneServer', 'apiIssuesController@postStatusIssuesDoneServer');

    Route::get('/getListDataAssetSimasti', 'apiIssuesController@getListDataAssetSimasti');

    Route::get('/getListDataAssetSimastiDenganNomor/{no}', 'apiIssuesController@getListDataAssetSimastiDenganNomor');

    Route::get('/getListDataAssetSimastiDenganTiketSismatiByTiketIssuesHelpdesk/{tiket_issues}', 'apiIssuesController@getListDataAssetSimastiDenganTiketSismatiByTiketIssuesHelpdesk');
    Route::get('/getListDataAssetSimastiDenganTiketSismatiByTiketIssuesDuplikatHelpdesk/{tiket_issues_duplikat}', 'apiIssuesController@getListDataAssetSimastiDenganTiketSismatiByTiketIssuesDuplikatHelpdesk');

    Route::get('/parsingDataIssuesSimasti', 'apiIssuesController@parsingDataIssuesSimasti');

    Route::get('/getListDataDetailPerbaikan/{no}', 'apiIssuesController@getListDataDetailPerbaikan');

    Route::get('/getListDataSyncNoAsset', 'apiIssuesController@getListDataSyncNoAsset');
});

Route::group(['middleware' => 'usersessionlogin'], function () { //middleware usersessionlogin di file CheckUserSessionLogin.php
    // Route::get('/', function () {
    //     // Uses User Session Middleware
    // });

    Route::group(['prefix' => 'firebase'], function () {
        Route::get('/getFirebaseData', 'firebaseController@getFirebaseData');
    });

    Route::get('/logout', 'loginController@logout');

    Route::group(['prefix' => 'home', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'homeController@index');
        Route::get('/getIssuesPerBulan/{kategori_search}/{tanggal_full_search}', 'homeController@getIssuesPerBulan');
        Route::get('/getCountIssuesPerBulan/{kategori_search}/{tanggal_full_search}', 'homeController@getCountIssuePerBulan');

        Route::get('/getJumlahIssueByKategori/{kategori_search}/{tanggal_full_search}', 'homeController@getJumlahIssueByKategori');
        Route::get('/getJumlahIssueByLayanan/{kategori_search}/{tanggal_full_search}', 'homeController@getJumlahIssueByLayanan');
        Route::get('/getJumlahIssueByLayananTop/{kategori_search}/{tanggal_full_search}', 'homeController@getJumlahIssueByLayananTop');
        Route::get('/getJumlahIssueBySubject', 'homeController@getJumlahIssueBySubject');
        Route::get('/getJumlahIssueBySubjectDatatable/{kategori_search}/{tanggal_full_search}', 'homeController@getJumlahIssueBySubjectDatatable');

        Route::get('/getDataDashboardIssueBulanan', 'homeController@getDataDashboardIssueBulanan');
    });

    Route::group(['prefix' => 'about', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'aboutController@index');
    });

    Route::group(['prefix' => 'issues', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'issuesController@index');
    });

    Route::group(['prefix' => 'user', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'userController@index');
        Route::get('/getDataUser', 'userController@getDataUser');
        Route::get('/getDataUserBy', 'userController@getDataUserBy');
        Route::post('/tambah', 'userController@tambah');
        Route::post('/update', 'userController@update');
        Route::get('/delete/{id}', 'userController@delete');
    });

    Route::group(['prefix' => 'pegawai', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'pegawaiController@index');
        Route::get('/getDataPegawai', 'pegawaiController@getDataPegawai');
    });

    Route::group(['prefix' => 'role', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'roleController@index');
        Route::get('/getDataRole', 'roleController@getDataRole');
        Route::post('/tambah', 'roleController@tambah');
        Route::post('/update', 'roleController@update');
        Route::get('/delete/{id}', 'roleController@delete');
    });

    Route::group(['prefix' => 'menu', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'menuController@index');
        Route::get('/getDataMenu', 'menuController@getDataMenu');
        Route::post('/tambah', 'menuController@tambah');
        Route::post('/update', 'menuController@update');
        Route::get('/delete/{id}', 'menuController@delete');
    });

    Route::group(['prefix' => 'sub_menu', 'middleware' => ['securexss']], function () {
        Route::get('/index/{menu_id}', 'subMenuController@index');
        Route::get('/getDataSubMenu/{menu_id}', 'subMenuController@getDataSubMenu');
        Route::post('/tambah', 'subMenuController@tambah');
        Route::post('/update', 'subMenuController@update');
        Route::get('/delete/{sub_menu_id}', 'subMenuController@delete');
    });

    Route::group(['prefix' => 'mapping_menu', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'mappingMenuController@index');
        Route::get('/getDataRoleMappingMenu', 'mappingMenuController@getDataRoleMappingMenu');
        Route::get('/getDataMappingMenu/{role_id}', 'mappingMenuController@getDataMappingMenu');
        Route::post('/update', 'mappingMenuController@update');
    });

    Route::group(['prefix' => 'kategori', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'kategoriController@index');
        Route::get('/getDataKategori', 'kategoriController@getDataKategori');
        Route::get('/getDataKategoriBy', 'kategoriController@getDataKategoriBy');
        Route::post('/tambah', 'kategoriController@tambah');
        Route::post('/update', 'kategoriController@update');
        Route::get('/delete/{id}', 'kategoriController@delete');

        Route::post('/updateStatusKategoriAktif', 'kategoriController@updateStatusKategoriAktif');
    });

    Route::group(['prefix' => 'layanan', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'layananController@index');
        Route::get('/getDataLayanan', 'layananController@getDataLayanan');
        Route::get('/getDataLayananBy', 'layananController@getDataLayananBy');
        Route::post('/tambah', 'layananController@tambah');
        Route::post('/update', 'layananController@update');
        Route::get('/delete/{id}', 'layananController@delete');

        Route::post('/updateStatusLayananAktif', 'layananController@updateStatusLayananAktif');
    });

    Route::group(['prefix' => 'faq_master', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'faqMasterController@index');
        Route::get('/getDataFaq', 'faqMasterController@getDataFaq');
        Route::post('/tambah', 'faqMasterController@tambah');
        Route::post('/update', 'faqMasterController@update');
        Route::get('/delete/{id}', 'faqMasterController@delete');

        Route::get('/indexDetail/{faq_id}', 'faqMasterController@indexDetail');
        Route::get('/getDataFaqDetail', 'faqMasterController@getDataFaqDetail');
        Route::post('/tambahDetail', 'faqMasterController@tambahDetail');
        Route::post('/updateDetail', 'faqMasterController@updateDetail');
        Route::get('/deleteDetail/{id}', 'faqMasterController@deleteDetail');
    });

    Route::group(['prefix' => 'faq', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'faqController@index');

        Route::get('/getDataFaqDatatable', 'faqController@getDataFaqDatatable');
        Route::get('/getDataFaqDetailDatatable', 'faqController@getDataFaqDetailDatatable');

        Route::get('/getDataFaq', 'faqController@getDataFaq');
        Route::get('/getDataFaqDetail', 'faqController@getDataFaqDetail');
    });

    Route::group(['prefix' => 'komplain', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'komplainController@index');
        Route::post('/tambah', 'komplainController@tambah');
        Route::get('/getDataKomplain', 'komplainController@getDataKomplain');

        Route::post('/update', 'komplainController@update');
        Route::get('/delete/{id}', 'komplainController@delete');
        Route::get('/getDataKomplainFile/{id}', 'komplainController@getDataKomplainFile');
        Route::get('/download_file/{file_name_dengan_extension}', 'komplainController@download_file');
    });

    Route::group(['prefix' => 'subject', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'subjectController@index');
        Route::get('/getDataSubject', 'subjectController@getDataSubject');
        Route::get('/getDataSubjectBy', 'subjectController@getDataSubjectBy');
        Route::post('/tambah', 'subjectController@tambah');
        Route::post('/update', 'subjectController@update');
        Route::get('/delete/{id}', 'subjectController@delete');

        Route::get('/getListLayanan/{m_kategori_id}', 'subjectController@getListLayanan');

        Route::post('/updateStatusSubjectAktif', 'subjectController@updateStatusSubjectAktif');
    });

    Route::group(['prefix' => 'pic', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'picController@index');
        Route::get('/getDataPIC', 'picController@getDataPIC');
        Route::post('/tambah', 'picController@tambah');
        Route::post('/update', 'picController@update');
        Route::get('/delete/{id}', 'picController@delete');

        Route::get('/getListLayanan/{m_kategori_id}', 'subjectController@getListLayanan');
    });

    Route::group(['prefix' => 'issues', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'issuesController@index');
        Route::get('/getDataIssues', 'issuesController@getDataIssues');
        Route::get('/getDataIssuesUnitKerja', 'issuesController@getDataIssuesUnitKerja');
        Route::get('/getDataIssuesForward', 'issuesController@getDataIssuesForward');
        Route::post('/tambah', 'issuesController@tambah');
        Route::post('/update', 'issuesController@update');
        Route::get('/delete/{id}', 'issuesController@delete');

        Route::get('/getListLayanan/{m_kategori_id}', 'issuesController@getListLayanan');
        Route::get('/getListSubject/{m_layanan_id}', 'issuesController@getListSubject');

        Route::get('/getDescriptionIssues/{tiket_issues}', 'issuesController@getDescriptionIssues');

        Route::get('/download_file/{file_name_dengan_extension}', 'issuesController@download_file');

        Route::get('/getListDataKomentar/{m_layanan_id}', 'issuesController@getListDataKomentar');

        Route::get('/getPegawaiSemuaSelect2', 'issuesController@getPegawaiSemuaSelect2');

        Route::post('/kirimKomentar', 'issuesController@kirimKomentar');

        Route::post('/tambahStatus', 'issuesController@tambahStatus');

        Route::get('/getDataLiburNasionalPerTahun/{tahun}', 'issuesController@getDataLiburNasionalPerTahun');
        Route::get('/getDataLiburNasionalPerTahunDistinctTanggal/{tahun}', 'issuesController@getDataLiburNasionalPerTahunDistinctTanggal');
        Route::get('/getDataLiburNasionalPerTahunBetween/{tanggal_awal}/{tanggal_akhir}', 'issuesController@getDataLiburNasionalPerTahunBetween');

        Route::get('/getListDataRiwayatStatusIssues/{tiket_issues}', 'issuesController@getListDataRiwayatStatusIssues');

        Route::get('/getIssuesForward/{tiket_issues}', 'issuesController@getIssuesForward');
        Route::post('/postUpdateIssuesForward', 'issuesController@postUpdateIssuesForward');

        Route::get('/surat_perjanjian_issues/{tiket_issues}', 'issuesController@surat_perjanjian_issues');
        Route::get('/surat_perjanjian_issues_bukan_inventaris_ti/{tiket_issues}', 'issuesController@surat_perjanjian_issues_bukan_inventaris_ti');
        Route::post('/update_tanda_tangan_surat_perjanjian_issues', 'issuesController@update_tanda_tangan_surat_perjanjian_issues');
        // Route::get('/surat_perjanjian_issues/{tiket_issues}', 'issuesController@surat_perjanjian_issues');
        // Route::post('/postUpdateIssuesForward', 'issuesController@postUpdateIssuesForward');
        Route::get('/getTandaTanganSuratPerjanjianIssues/{tiket_issues}', 'issuesController@get_tanda_tangan_surat_perjanjian_issues');

        Route::post('/postUpdateIssuesPriority', 'issuesController@postUpdateIssuesPriority');

        Route::post('/postUpdateIssuesLayananDanSubject', 'issuesController@postUpdateIssuesLayananDanSubject');

        Route::get('/getPutSessionTiketIssuesSearch', 'issuesController@getPutSessionTiketIssuesSearch');

        Route::get('/getPriorityRefreshKembali/{tiket_issues}', 'issuesController@getPriorityRefreshKembali');

        Route::get('/download_qr_code_issues/{tiket_issues}', 'issuesController@download_qr_code_issues');

        Route::post('/tambahFileIssuesModal', 'issuesController@tambahFileIssuesModal');

        Route::post('/getFileIssuesModal', 'issuesController@getFileIssuesModal');

        Route::post('/deleteFileIssuesModal', 'issuesController@deleteFileIssuesModal');

        Route::post('/securityincidentupdate', 'issuesController@securityincidentupdate');
        Route::post('/majorincidentupdate', 'issuesController@majorincidentupdate');

        Route::get('/getLiburNasional', 'issuesController@getLiburNasional');
    });

    Route::group(['prefix' => 'libur_nasional', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'liburNasionalController@index');
        Route::get('/getLiburNasional', 'liburNasionalController@getLiburNasional');
        Route::post('/tambah', 'liburNasionalController@tambah');
        // Route::post('/update', 'liburNasionalController@update');
        Route::get('/delete/{id}', 'liburNasionalController@delete');
    });

    Route::group(['prefix' => 'rekap_data_issues', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'rekapDataIssuesController@index');
        Route::get('/getDataIssues', 'rekapDataIssuesController@getDataIssues');
        Route::get('/export_pdf', 'rekapDataIssuesController@export_pdf');
        Route::get('/export_excel', 'rekapDataIssuesController@export_excel');
    });

    Route::group(['prefix' => 'rekap_data_issues_bulanan', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'rekapDataIssuesBulananController@index');
        Route::get('/getDataIssues', 'rekapDataIssuesBulananController@getDataIssues');
        Route::get('/export_pdf', 'rekapDataIssuesBulananController@export_pdf');
        Route::get('/export_excel', 'rekapDataIssuesBulananController@export_excel');
    });

    Route::group(['prefix' => 'kinerja_pegawai', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'kinerjaPegawaiController@index');
    });
    Route::group(['prefix' => 'repositori', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'repositoriController@index');
        Route::get('/getDataAllFiles', 'repositoriController@getDataFiles');
        Route::get('/getFileBy', 'repositoriController@getFileBy');
        Route::post('/tambah', 'repositoriController@tambah');
        Route::get('/download/{filepath}', 'repositoriController@download');
        Route::get('/zipdownload', 'repositoriController@zipdownload');
        Route::get('/delete/{filepath}', 'repositoriController@deleteFile');
    });
    Route::group(['prefix' => 'notifikasi', 'middleware' => ['securexss']], function () {
        Route::get('/index', 'notifikasiController@index');
        Route::get('/getNotifikasi', 'notifikasiController@getNotifikasi');
        Route::get('/clickIcon', 'notifikasiController@clickIcon');
        Route::post('/readAt', 'notifikasiController@changeReadAt');
        Route::get('/customserch', 'notifikasiController@getNotifByTgl');
    });
});
