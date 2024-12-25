<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class kategoriController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next){
            if(in_array(get_nama_current_path_root_group(), get_sub_menu())){
                return $next($request);
            }else{
                return response()->view('tidak_ditemukan.pages_404');
            }
        });
    }

    public function index()
    {
        $data['judul'] = "Manage Kategori";
        $data['m_kategori'] = DB::table('m_kategori')
            ->select(DB::raw("m_kategori.*"))
            ->get();

        $data['m_flag'] = DB::table('m_flag')
            ->select(DB::raw("m_flag.*"))
            ->get();

        return view('pages.kategori.index', $data);
    }

    public function getDataKategori(Request $request)
    {

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {
            $tb_m_kategori = DB::table('m_kategori')
                ->select(DB::raw("m_kategori.*"));

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_kategori->count();


            $m_kategori = $tb_m_kategori
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_kategori) > 0) {

                foreach ($m_kategori as $value) {
                    // dd($value['nama']);

                    $status_checked = "";

                    if($value->status_aktif == true){
                        $status_checked = "checked";
                    }else{
                        $status_checked = "";
                    }

                    $datas[] = array(

                        'no' => $no++,
                        'nama_kategori' => $value->nama_kategori,
                        'aksi' =>
                        '<table>' .
                        '<tr>' .
                        '<td>' .
                        '<div class="form-switch">
                            <input class="form-check-input" ' . $status_checked . ' data-kategori_id="' . $value->id . '" type="checkbox" role="switch" id="status_aktif" name="status_aktif" style="width:55px; height:30px; margin-bottom:8px; margin-right:8px;">
                        </div>'.
                        '</td>' .
                        '<td>' .
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditKategori"
                        data-kategori_id="' . $value->id . '" 
                        data-nama_kategori="' . $value->nama_kategori . '" 
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button>' .
                        '</td>' .
                        '</tr>' .
                        '</table>'
                    );
                }
            } else {
                $datas = array();
            }

            // dd($datas);
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function getDataKategoriBy(Request $request)
    {
        $nama_kategori = $request->nama_kategori;

        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $resultData = array();
        $data_arr = [
            'limit' => $limit,
            'offset' => $offset,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {
            $query = DB::table('m_kategori')
                ->select(
                'm_kategori.nama_kategori as nama_kategori', 
                'm_kategori.status_aktif',
                'm_kategori.id as kategori_id')
                ->Where(function ($query) use (
                    $nama_kategori
                ) {
                    is_null($nama_kategori) || $nama_kategori == '' ?: $query->where('m_kategori.nama_kategori', 'ilike', '%' . $nama_kategori . '%');
                });

            if (!is_null($nama_kategori)) {
                $query = $query->where('m_kategori.nama_kategori', 'iLIKE', '%' . $nama_kategori . '%');
            }

            $total_data = $query->count();
            $kategori = $query
                ->orderBy('m_kategori.nama_kategori', 'asc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];
            $no = $offset + 1;

            if (count($kategori) > 0) {
                foreach ($kategori as $item) {
                    $status_checked = "";

                    if($item->status_aktif == true){
                        $status_checked = "checked";
                    }else{
                        $status_checked = "";
                    }

                    $datas[] = array(

                        'no' => $no++,
                        'nama_kategori' => $item->nama_kategori,
                        'aksi' =>
                        '<table>' .
                        '<tr>' .
                        '<td>' .
                        '<div class="form-switch">
                            <input class="form-check-input" ' . $status_checked . ' data-kategori_id="' . $item->kategori_id . '" type="checkbox" role="switch" id="status_aktif" name="status_aktif" style="width:55px; height:30px; margin-bottom:8px; margin-right:8px;">
                        </div>'.
                        '</td>' .
                        '<td>' .
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditKategori"
                        data-kategori_id="' . $item->kategori_id . '" 
                        data-nama_kategori="' . $item->nama_kategori . '" 
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button>' .
                        '</td>' .
                        '</tr>' .
                        '</table>'
                    );
                }
            } else {
                $datas = array();
            }

            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;

            return response()->json(compact("data", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'Anda belum login', 'kode' => 401]);
        }
    }


    public function tambah(Request $request)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $nama_kategori = $request->nama_kategori;

        if (validateSessionToken($get_session_token)) {
            $tb_m_kategori = DB::table('m_kategori')
                ->select(DB::raw("m_kategori.*"))
                ->get();

            $tb_m_kategori_count = count($tb_m_kategori);

            // return response()->json($tb_m_kategori_count);

            if ($tb_m_kategori_count == 0) {
                $tambah_kategori = DB::table('m_kategori')
                    ->insert([
                        'id' => 'K01',
                        'nama_kategori' => $nama_kategori,
                        'status_aktif' => false,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            } else {

                $tb_m_kategori_get_id_terakhir = DB::table('m_kategori')
                    ->select(DB::raw("m_kategori.*"))
                    ->orderby('m_kategori.id', 'DESC')
                    // ->limit(1)
                    ->get()
                    ->first();

                // return response()->json($tb_m_kategori_get_id_terakhir->id);

                $tambah_kategori = DB::table('m_kategori')
                    ->insert([
                        'id' => next_value_nuber_2_digit($tb_m_kategori_get_id_terakhir->id),
                        'nama_kategori' => $nama_kategori,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            }

            return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function update(Request $request)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $kategori_id_edit = $request->kategori_id_edit;
        $nama_kategori_edit = $request->nama_kategori_edit;

        if (validateSessionToken($get_session_token)) {
            $kategori_id_edit = $request->kategori_id_edit;
            $nama_kategori_edit = $request->nama_kategori_edit;

            $update_m_kategori = DB::table('m_kategori')
                ->where('m_kategori.id', '=', $kategori_id_edit)
                ->update([
                    'nama_kategori' => $nama_kategori_edit,
                ]);


            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function delete(Request $request, $id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $delete_m_kategori = DB::table('m_kategori')
                ->where('m_kategori.id', '=', $id)
                ->delete();

            $delete_m_layanan = DB::table('m_layanan')
                ->where('m_layanan.m_kategori_id', '=', $id)
                ->delete();

            $delete_m_subject = DB::table('m_subject')
                ->where('m_subject.m_kategori_id', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function updateStatusKategoriAktif(Request $request)
    {
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        // dd($request->all());

        $kategori_id = $request->kategori_id;
        $status_aktif = $request->status_aktif;

        if (validateSessionToken($get_session_token)) {

            $update_m_kategori = DB::table('m_kategori')
                ->where('m_kategori.id', '=', $kategori_id)
                ->update([
                    'status_aktif' => $status_aktif,
                ]);

            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }
}
