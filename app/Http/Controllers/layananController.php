<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class layananController extends Controller
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
        $data['judul'] = "Manage Layanan";
        $data['m_kategori'] = DB::table('m_kategori')
            ->select(DB::raw("m_kategori.*"))
            ->get();

        $data['m_flag'] = DB::table('m_flag')
            ->select(DB::raw("m_flag.*"))
            ->get();

        return view('pages.layanan.index', $data);
    }

    public function getDataLayanan(Request $request)
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
            $tb_m_layanan = DB::table('m_layanan')
                ->select(DB::raw("m_layanan.*, m_kategori.id as m_kategori_id, m_kategori.nama_kategori"))
                ->join('m_kategori', 'm_kategori.id', '=', 'm_layanan.m_kategori_id');

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_layanan->count();


            $m_layanan = $tb_m_layanan
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_layanan) > 0) {

                foreach ($m_layanan as $value) {
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
                        'nama_layanan' => $value->nama_layanan,
                        'jam_layanan' => $value->jam_layanan,
                        'deskripsi_layanan' => $value->deskripsi_layanan,
                        'aksi' =>
                        '<table>' .
                        '<tr>' .
                        '<td>' .
                        '<div class="form-switch">
                            <input class="form-check-input" ' . $status_checked . ' data-layanan_id="' . $value->id . '" type="checkbox" role="switch" id="status_aktif" name="status_aktif" style="width:55px; height:30px; margin-bottom:8px; margin-right:8px;">
                        </div>'.
                        '</td>' .
                        '<td>' .
                        '<button type="button" name="edit" id="edit"
                        class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditKategori"
                        data-layanan_id="' . $value->id . '"
                        data-nama_layanan="' . $value->nama_layanan . '"
                        data-kategori_id="' . $value->m_kategori_id . '"
                        data-jam_layanan="' . $value->jam_layanan . '"
                        data-deskripsi_layanan="' . $value->deskripsi_layanan . '"
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button>'.
                            // '<button type="button" name="delete" id="delete" data-layanan_id="' . $value->id . '" class="mb-1 me-1 btn btn-danger btn-xs" href=' . '' . '><i class="mdi mdi-trash-can"></i> Hapus </button>'
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

    public function getDataLayananBy(Request $request)
    {
        $nama_kategori = $request->nama_kategori;
        $nama_layanan = $request->nama_layanan;
        $jam_layanan = $request->jam_layanan;
        $deskripsi_layanan = $request->deskripsi_layanan;

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
            $query = DB::table('m_layanan')
                ->select(DB::raw("m_layanan.*, m_kategori.id as m_kategori_id, m_kategori.nama_kategori, m_layanan.id as layanan_id"))
                ->join('m_kategori', 'm_kategori.id', '=', 'm_layanan.m_kategori_id')
                ->Where(function ($query) use (
                    $nama_kategori,
                    $nama_layanan,
                    $jam_layanan,
                    $deskripsi_layanan
                ) {
                    is_null($nama_kategori) || $nama_kategori == '' ?: $query->where('m_kategori.nama_kategori', 'ilike', '%' . $nama_kategori . '%');
                    is_null($nama_layanan) || $nama_layanan == '' ?: $query->where('m_layanan.nama_layanan', 'ilike', '%' . $nama_layanan . '%');
                    is_null($jam_layanan) || $jam_layanan == '' ?: $query->where('m_layanan.jam_layanan', 'ilike', '%' . $jam_layanan . '%');
                    is_null($deskripsi_layanan) || $deskripsi_layanan == '' ?: $query->where('m_layanan.deskripsi_layanan', 'ilike', '%' . $deskripsi_layanan . '%');
                });

            $total_data = $query->count();
            $layanan = $query
                ->orderBy('m_layanan.nama_layanan', 'asc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];
            $no = $offset + 1;

            if (count($layanan) > 0) {
                foreach ($layanan as $item) {

                    $status_checked = "";

                    if($item->status_aktif == true){
                        $status_checked = "checked";
                    }else{
                        $status_checked = "";
                    }

                    $datas[] = array(
                        'no' => $no++,
                        'nama_kategori' => $item->nama_kategori,
                        'nama_layanan' => $item->nama_layanan,
                        'jam_layanan' => $item->jam_layanan,
                        'deskripsi_layanan' => $item->deskripsi_layanan,
                        'aksi' =>
                        '<table>' .
                        '<tr>' .
                        '<td>' .
                        '<div class="form-switch">
                            <input class="form-check-input" ' . $status_checked . ' data-layanan_id="' . $item->id . '" type="checkbox" role="switch" id="status_aktif" name="status_aktif" style="width:55px; height:30px; margin-bottom:8px; margin-right:8px;">
                        </div>'.
                        '</td>' .
                        '<td>' .
                        '<button type="button" name="edit" id="edit"
                        class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditKategori"
                        data-layanan_id="' . $item->id . '"
                        data-nama_layanan="' . $item->nama_layanan . '"
                        data-kategori_id="' . $item->m_kategori_id . '"
                        data-jam_layanan="' . $item->jam_layanan . '"
                        data-deskripsi_layanan="' . $item->deskripsi_layanan . '"
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit </button>'.
                        // '<button type="button" name="delete" id="delete" data-layanan_id="' . $item->layanan_id . '" class="btn btn-danger btn-xs"><i class="mdi mdi-trash-can"></i> Hapus</button>'
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
        // dd('coba');
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $kategori_id = $request->kategori_id;
        $nama_layanan = $request->nama_layanan;
        $jam_layanan = $request->jam_layanan;
        $deskripsi_layanan = $request->deskripsi_layanan;

        if (validateSessionToken($get_session_token)) {
            $tb_m_layanan = DB::table('m_layanan')
                ->select(DB::raw("m_layanan.*"))
                ->get();

            $tb_m_layanan_count = count($tb_m_layanan);

            // return response()->json($tb_m_layanan_count);

            if ($tb_m_layanan_count == 0) {
                $tambah_layanan = DB::table('m_layanan')
                    ->insert([
                        'id' => 'L001',
                        'm_kategori_id' => $kategori_id,
                        'nama_layanan' => $nama_layanan,
                        'jam_layanan' => $jam_layanan,
                        'deskripsi_layanan' => $deskripsi_layanan,
                        'created_at' => Carbon::now()
                    ]);
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
            } else {

                $tb_m_layanan_get_id_terakhir = DB::table('m_layanan')
                    ->select(DB::raw("m_layanan.*"))
                    ->orderby('m_layanan.id', 'DESC')
                    // ->limit(1)
                    ->get()
                    ->first();

                // return response()->json($tb_m_layanan_get_id_terakhir->id);

                $tambah_layanan = DB::table('m_layanan')
                    ->insert([
                        'id' => next_value($tb_m_layanan_get_id_terakhir->id),
                        'm_kategori_id' => $kategori_id,
                        'nama_layanan' => $nama_layanan,
                        'jam_layanan' => $jam_layanan,
                        'deskripsi_layanan' => $deskripsi_layanan,
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

        $layanan_id_edit = $request->layanan_id_edit;
        $kategori_id_edit = $request->kategori_id_edit;
        $nama_layanan_edit = $request->nama_layanan_edit;
        $jam_layanan_edit = $request->jam_layanan_edit;
        $deskripsi_layanan_edit = $request->deskripsi_layanan_edit;

        if (validateSessionToken($get_session_token)) {
            // $layanan_id_edit = $request->layanan_id_edit;
            // $nama_layanan_edit = $request->nama_layanan_edit;

            $update_m_layanan = DB::table('m_layanan')
                ->where('m_layanan.id', '=', $layanan_id_edit)
                ->update([
                    // 'm_kategori_id' => $kategori_id_edit,
                    'nama_layanan' => $nama_layanan_edit,
                    'jam_layanan' => $jam_layanan_edit,
                    'deskripsi_layanan' => $deskripsi_layanan_edit,
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

            $delete_m_layanan = DB::table('m_layanan')
                ->where('m_layanan.id', '=', $id)
                ->delete();

            $delete_m_subject = DB::table('m_subject')
                ->where('m_subject.m_layanan_id', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function updateStatusLayananAktif(Request $request)
    {
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        // dd($request->all());

        $layanan_id = $request->layanan_id;
        $status_aktif = $request->status_aktif;

        if (validateSessionToken($get_session_token)) {

            $update_m_layanan = DB::table('m_layanan')
                ->where('m_layanan.id', '=', $layanan_id)
                ->update([
                    'status_aktif' => $status_aktif,
                ]);

            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }
}
