<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class picController extends Controller
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
        $data['judul'] = "Manage PIC";
        $data['m_pic'] = DB::table('m_pic')
            ->select(DB::raw("m_pic.*"))
            ->get();

        $data['m_flag'] = DB::table('m_flag')
            ->select(DB::raw("m_flag.*"))
            ->get();

        $data['m_kategori'] = DB::table('m_kategori')
            ->select(DB::raw("m_kategori.*"))
            ->get();

        $data['m_layanan'] = DB::table('m_layanan')
            ->select(DB::raw("m_layanan.*"))
            ->get();

        return view('pages.pic.index', $data);
    }

    public function getDataPIC(Request $request)
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
            $tb_m_pic = DB::table('m_pic')
                ->select(DB::raw("m_pic.*, m_layanan.m_kategori_id, m_layanan.nama_layanan, m_kategori.nama_kategori, v_users_all.nama as v_users_all_nama"))
                ->leftJoin('m_layanan', 'm_layanan.id', '=', 'm_pic.layanan_id')
                ->leftJoin('m_kategori', 'm_kategori.id', '=', 'm_layanan.m_kategori_id')
                ->leftJoin('v_users_all', 'v_users_all.username', '=', 'm_pic.username');

            // $datax['total_data'] = $tb_users->first();
            $total_data = $tb_m_pic->count();


            $m_pic = $tb_m_pic
                ->limit($limit)
                ->offset($offset)
                ->get();


            $datas = [];

            $no = $offset + 1;

            if (count($m_pic) > 0) {

                foreach ($m_pic as $value) {
                    // dd($value['nama']);

                    $datas[] = array(

                        'no' => $no++,
                        'username' => $value->username,
                        'v_users_all_nama' => $value->v_users_all_nama,
                        'nama_kategori' => $value->nama_kategori,
                        'nama_layanan' => $value->nama_layanan,
                        'aksi' =>
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalFormEditPic"
                        data-pic_id="' . $value->id . '" 
                        data-username="' . $value->username . '" 
                        data-m_kategori_id="' . $value->m_kategori_id . '" 
                        data-layanan_id="' . $value->layanan_id . '" 
                        >
                        <i class="mdi mdi-square-edit-outline me-1"></i> Edit </button> &nbsp;' .
                            '<button type="button" name="delete" id="delete" data-pic_id="' . $value->id . '" class="btn btn-danger btn-xs" href=' . '' . '><i class="mdi mdi-trash-can"></i> hapus </button>'
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

    public function tambah(Request $request)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $username = $request->username;
        $layanan_id = $request->layanan_id;

        if (validateSessionToken($get_session_token)) {

            // return response()->json($tb_m_kategori_count);

            $tambah_m_pic = DB::table('m_pic')
                ->insert([
                    'username' => $username,
                    'layanan_id' => $layanan_id,
                    'created_at' => Carbon::now()
                ]);
            return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function update(Request $request)
    {

        // dd($request->all());
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        $pic_id_edit = $request->pic_id_edit;
        $username_edit = $request->username_edit;
        $kategori_id_edit = $request->m_kategori_id;
        $layanan_id_edit = $request->layanan_id_edit;

        if (validateSessionToken($get_session_token)) {

            $update_m_pic = DB::table('m_pic')
                ->where('m_pic.id', '=', $pic_id_edit)
                ->update([
                    'username' => $username_edit,
                    'layanan_id' => $layanan_id_edit,
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

            $delete_m_kategori = DB::table('m_pic')
                ->where('m_pic.id', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function getListLayanan(Request $request, $m_kategori_id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {

            $get_m_layanan = DB::table('m_layanan')
                ->where('m_layanan.m_kategori_id', '=', $m_kategori_id)
                ->get();

            // $html_option = "";

            foreach ($get_m_layanan as $data) {
                $html_option .= '<option value="' . $data->id . '">' . $data->nama_layanan . '</option>';
            }

            return response()->json(['data' => $html_option]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }
}
