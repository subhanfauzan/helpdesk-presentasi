<?php

namespace App\Http\Controllers;
use DB;
use PDF;
// use Illuminate\Support\Facades\Session;
use URL;
use File;
use Session;
use Response;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use GuzzleHttp\Exception\BadResponseException;
use Guzzle\Http\Exception\ClientErrorResponseException;

use Illuminate\Support\Facades\Log;

class komplainController extends Controller
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
        $data['judul'] = "Komplain";
        $data['komplain'] = DB::table('komplain')
            ->select(DB::raw("komplain.*"))
            ->get();

        return view('pages.komplain.index', $data);
    }

   public function tambah(Request $request)
    {
        // dd($request->all());
        // Mendapatkan data sesi pengguna
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_username = $get_session['username'];
        $get_session_unit_id = $get_session['unitId'];
        $file_komplain = $request->file('file_komplain');
        $file_komplain_jumlah = is_null($file_komplain) ? 0 : count($file_komplain);

        // Mendapatkan data dari request
        $deskripsi = $request->deskripsi;
        $kategori = $request->kategori;

        // dd($deskripsi, $kategori, $get_session_username, $get_session_token);

        if (validateSessionToken($get_session_token)) {
            // Jika tabel 'komplain' kosong
                $accepted = array('doc', 'xls', 'docx', 'xlsx', 'pdf', 'mp3', 'aav', 'mp4', 'mkv', 'jpg', 'jpeg', 'png', 'svg', 'zip');
                // $texts = array('<script>','</script>','<?','>','{{','}}','<?php');
                for ($i = 0; $i < $file_komplain_jumlah; $i++) {
                    $name = $file_komplain[$i]->getClientOriginalName();
                    $ext = $file_komplain[$i]->extension();
                    if (in_array(strtolower($ext), $accepted)) {
                    } else {
                        return response()->json(['success' => 'Attachment file tidak dapat diupload', 'kode' => 401]);
                    }
                }

                $tb_komplain = DB::table('komplain')
                    ->insertGetId([
                        'kategori' => $kategori,
                        'deskripsi' => $deskripsi,
                        'unit_id' => $get_session_unit_id,
                        'created_at' => Carbon::now(),
                        'created_by' => $get_session_username,
                    ]);

                for ($i = 0; $i < $file_komplain_jumlah; $i++) {

                    $filename_dengan_extension = $file_komplain[$i]->getClientOriginalName();
                    $filename_tanpa_extension = pathinfo($filename_dengan_extension, PATHINFO_FILENAME);

                    // dd(pathinfo($filename, PATHINFO_FILENAME));

                    // dd($filename);

                    $filepath = $filename_tanpa_extension . '_' . rand(1000, 9999) . '.' . $file_komplain[$i]->getClientOriginalExtension();

                    //file pada folder file_lampiran_usulan_kenaikan_pangkat di delete terlebih dahulu
                    $file_delete = public_path() . '/file_komplain/' . $filepath;
                    File::delete($file_delete);

                    //setelah file di folder file_lampiran_usulan_kenaikan_pangkat sudah di delete baru dimasukan file yang baru
                    $destinationPath = public_path() . '/file_komplain/';
                    $file_komplain[$i]->move($destinationPath, $filepath);

                    // dd($filepath);

                    $tambah_komplain_file = DB::table('komplain_file')
                        ->insert([
                            'komplain_id' => $tb_komplain,
                            'file_name' => $filepath,
                            'file_extension' => $file_komplain[$i]->getClientOriginalExtension(),
                            'created_at' => Carbon::now(),
                            'created_by' => $get_session_username,
                        ]);
                }
                // dd($tb_komplain);
                // Mengembalikan respons JSON dengan status sukses
                return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);

        } else {
            // Jika pengguna belum login, mengembalikan respons JSON dengan status error
            return response()->json(['error' => 'Anda belum login', 'kode' => 401]);
        }
    }

    public function getDataKomplain(Request $request)
    {
        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_username = $get_session['username'];
        $get_session_gradename = $get_session['gradename'];
        $get_session_flag = $get_session['flag'];
        $get_session_role = $get_session['role'];
        $get_session_unit_id = $get_session['unitId'];

        if (validateSessionToken($get_session_token)) {
            $tb_komplain = DB::table('komplain')
                ->select(DB::raw('komplain.*, pegawai.nama as pegawai_nama'))
                ->leftJoin('pegawai', 'pegawai.nik', '=', 'komplain.created_by');

            if($get_session_role == 'R003'){ // ketika role pegawai
                // dd('coba');
                // dd($get_session_gradename);
                // dd(str_contains($get_session_gradename, "VP"));
                if (str_contains($get_session_gradename, "VP") == true || str_contains($get_session_gradename, "AVP") == true) { // ketika VP dan AVP
                    $tb_komplain = $tb_komplain
                    ->where('unit_id', '=', $get_session_unit_id);
                }else{
                    $tb_komplain = $tb_komplain
                    ->where('created_by', '=', $get_session_username)
                    ->where('unit_id', '=', $get_session_unit_id);
                }
                
            }

            $total_data = $tb_komplain->count();

            $komplain = $tb_komplain
                ->orderBy('created_at', 'DESC')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];

            $no = $offset + 1;

            if ($komplain->isNotEmpty()) {
                foreach ($komplain as $value) {

                    $tb_komplain_file = DB::table('komplain_file')
                        ->select(DB::raw('komplain_file.*'))
                        ->where('komplain_file.komplain_id', '=', $value->id)
                        ->get();

                    $file_link_array = '';

                    foreach($tb_komplain_file as $data_komplain_file){
                        $file_link_array .=
                            '<a href="download_file/' . $data_komplain_file->file_name . '" target="_blank">' . $data_komplain_file->file_name . '</a>' .
                            '<br>';
                    }

                    $datas[] = array(
                        'no' => $no++,
                        'kategori' => $value->kategori,
                        'deskripsi' => $value->deskripsi,
                        'pegawai_nama' => $value->pegawai_nama,
                        'komplain_file' => $file_link_array,
                        'created_at' => $value->created_at,
                        'aksi' =>
                        '<button type="button" name="edit" id="edit" 
                        class="btn btn-primary waves-effect waves-light mb-1 me-1" data-bs-toggle="modal" data-bs-target="#modalFormEditKomplain"
                        data-id="' . $value->id . '" 
                        data-kategori="' . $value->kategori . '"
                        data-deskripsi="' . $value->deskripsi . '"
                        >
                        <i class="mdi mdi-square-edit-outline"></i> Edit</button>' .
                        '<button type="button" name="delete" id="delete" data-komplain_id="' . $value->id . '" class="mb-1 me-1 btn btn-danger btn-xs"><i class="mdi mdi-trash-can"></i> Hapus </button>'
                    );
                }
            } else {
                $datas = [];
            }

            $recordsTotal = $total_data ?? 0;
            $recordsFiltered = $total_data ?? 0;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function delete(Request $request, $id)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        

        if (validateSessionToken($get_session_token)) {
            $delete_komplain_file = DB::table('komplain_file')
                ->select('komplain_file.*')
                ->where('komplain_id', '=', $id)
                ->get();
                
            foreach($delete_komplain_file as $data){
                $file_delete = public_path() . '/file_komplain/' . $data->file_name;
                File::delete($file_delete);
            }

            $delete_komplain = DB::table('komplain')
                ->where('komplain.id', '=', $id)
                ->delete();

            $delete_komplain_file = DB::table('komplain_file')
                ->where('komplain_file.komplain_id', '=', $id)
                ->delete();

            return response()->json(['success' => 'Data Berhasil Didelete', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function update(Request $request)
    {

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_username = $get_session['username'];

        $komplain_id_edit = $request->komplain_id_edit;
        $kategori_edit = $request->kategori_edit;
        $deskripsi_komplain_edit = $request->deskripsi_komplain_edit;
        $data_komplain_file_id_array_delete = $request->data_komplain_file_id_array_delete;
        $file_komplain_edit = $request->file('file_komplain_edit');
        $file_komplain_edit_jumlah = is_null($file_komplain_edit) ? 0 : count($file_komplain_edit);

        if (validateSessionToken($get_session_token)) {
            // $layanan_id_edit = $request->layanan_id_edit;
            // $nama_layanan_edit = $request->nama_layanan_edit;

            // dd($request->all());
            // dd($data_komplain_file_id_array_delete);
            if($data_komplain_file_id_array_delete != null){
                $data_komplain_file_id_array_delete = explode(",",$data_komplain_file_id_array_delete);
                $delete_komplain_file = DB::table('komplain_file')
                    ->select('komplain_file.*')
                    ->whereIn('id', $data_komplain_file_id_array_delete)
                    ->get();

                foreach($delete_komplain_file as $data){
                    $file_delete = public_path() . '/file_komplain/' . $data->file_name;
                    File::delete($file_delete);
                }

                $delete_komplain_file = DB::table('komplain_file')
                    ->whereIn('komplain_file.id', $data_komplain_file_id_array_delete)
                    ->delete();
            }

            if($file_komplain_edit_jumlah > 0){

                for ($i = 0; $i < $file_komplain_edit_jumlah; $i++) {

                    $filename_dengan_extension = $file_komplain_edit[$i]->getClientOriginalName();
                    $filename_tanpa_extension = pathinfo($filename_dengan_extension, PATHINFO_FILENAME);
    
                    $filepath = $filename_tanpa_extension . '_' . rand(1000, 9999) . '.' . $file_komplain_edit[$i]->getClientOriginalExtension();
    
                    //file pada folder file_lampiran_usulan_kenaikan_pangkat di delete terlebih dahulu
                    $file_delete = public_path() . '/file_komplain/' . $filepath;
                    File::delete($file_delete);
    
                    //setelah file di folder file_lampiran_usulan_kenaikan_pangkat sudah di delete baru dimasukan file yang baru
                    $destinationPath = public_path() . '/file_komplain/';
                    $file_komplain_edit[$i]->move($destinationPath, $filepath);
    
                    $tambah_komplain_file = DB::table('komplain_file')
                        ->insert([
                            'komplain_id' => $komplain_id_edit,
                            'file_name' => $filepath,
                            'file_extension' => $file_komplain_edit[$i]->getClientOriginalExtension(),
                            'created_at' => Carbon::now(),
                            'created_by' => $get_session_username,
                        ]);
                }
                
            }

            $update_komplain = DB::table('komplain')
                ->where('id', '=', $komplain_id_edit)
                ->update([
                    'kategori' => $kategori_edit,
                    'deskripsi' => $deskripsi_komplain_edit,
                ]);


            return response()->json(['success' => 'Data Berhasil Diupdate', 'kode' => 201]);
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        };
    }

    public function getDataKomplainFile(Request $request, $id)
    {
        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $draw = $request["draw"];
        $searchs = $request["search.value"];
        $resultData = array();
        $data_arr = [
            'limit' => $limit,
            'offset' => $offset,
            'searchs' => $searchs,
            'dirs' => $dirs,
        ];
        if($request->data_parsing != null){
            $data_komplain_file_id_array = $request->data_parsing;
            $data_komplain_file_id_array_count = count($data_komplain_file_id_array);
        }else{
            $data_komplain_file_id_array_count = 0;
        }
        // dd($data_komplain_file_id_array);

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_username = $get_session['username'];

        $kategori_id_edit = $id;

        // dd(count($data_komplain_file_id_array));

        if (validateSessionToken($get_session_token)) {
            $tb_komplain = DB::table('komplain_file')
                ->select('komplain_file.*')
                ->where('komplain_id', '=', $kategori_id_edit);

            // dd(count($data_komplain_file_id_array));
            if($data_komplain_file_id_array_count > 0){
                $tb_komplain = $tb_komplain->whereNotIn('id', $data_komplain_file_id_array);
            }

            $total_data = $tb_komplain->count();

            $komplain = $tb_komplain
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];

            $no = $offset + 1;

            if ($komplain->isNotEmpty()) {
                foreach ($komplain as $value) {
                    $datas[] = array(
                        'no' => $no++,
                        'nama_file' => $value->file_name,
                        'file_extension' => $value->file_extension,
                        'created_at' => $value->created_at,
                        'created_by' => $value->created_by,
                        'aksi' =>
                        '<button type="button"  name="delete_komplain_file" id="delete_komplain_file" data-komplain_id="' . $value->id . '" class="mb-1 me-1 btn btn-danger btn-xs delete_komplain_file"><i class="mdi mdi-trash-can"></i> </button>'
                    );
                }
            } else {
                $datas = [];
            }

            $recordsTotal = $total_data ?? 0;
            $recordsFiltered = $total_data ?? 0;
            $data = $datas;

            return response()->json(compact("data", "draw", "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function download_file($file_name_dengan_extension)
    {
        $file = public_path() . "/file_komplain/$file_name_dengan_extension";

        return response()->download($file);
    }
}
