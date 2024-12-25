<?php

namespace App\Http\Controllers;

use DB;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class repositoriController extends Controller
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
        $data['judul'] = "Repositori";
        return view('pages.repositori.index', $data);
    }

    public function getDataFiles(Request $request){
        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $nik = $get_session['username'];

        if (validateSessionToken($get_session_token)) {
            $tab = $request->tab;

            if ($tab == "semua") {
                $tb_file =  DB::table('repositori')
                ->join('v_users_all', 'repositori.nik_pegawai', '=', 'v_users_all.username')
                ->select(DB::raw('repositori.*, v_users_all.nama as nama'))
                ->orderBy('repositori.created_at', 'desc');
                $init= "all";
            } else if($tab == "pribadi"){
                $tb_file =  DB::table('repositori')
                ->join('v_users_all', 'repositori.nik_pegawai', '=', 'v_users_all.username')
                ->select(DB::raw('repositori.*, v_users_all.nama as nama'))
                ->where('repositori.nik_pegawai', '=', $nik)
                ->orderBy('repositori.created_at', 'desc');
                $init= "my";
            }
            $total_data = $tb_file->count();
            $repositori = $tb_file
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];

            $no = $offset + 1;

            if (count($repositori) > 0) {
                foreach ($repositori as $value) {
                    $filepath_temp = "'".$value->filepath."'";
                    $fullname = "'".$value->nama_file.".".$value->format_file."'";
                    $id = 'row_'.preg_replace('/\s+/', '_', $value->filepath);

                    $aksi = '<a type="button" href="'.url('repositori/download').'/'.$value->filepath.'" target="_blank" class="btn btn-primary btn-xs ms-1 mb-1 "><i class="mdi mdi-cloud-download"></i></a>'
                    .'<button type="button"  onclick="addToCart('.$filepath_temp.')" class="btn btn-success btn-xs ms-1 mb-1"><i class="mdi mdi-checkbox-marked"></i></button>';
                    $delete = '<button type="button" onclick="deleteclick('.$fullname.', '.$filepath_temp.')" class="btn btn-danger btn-xs ms-1 mb-1"><i class="mdi mdi-trash-can"></i></button>';
                    if( $nik == $value->nik_pegawai){
                        $aksi .= $delete;
                    }

                    $datas[] = array(
                        'DT_RowId' => $init."_".$id,
                        'no' => $no++,
                        'nama_file' => $value->nama_file,
                        'format_file' => $value->format_file,
                        'deskripsi' => $value->deskripsi_file,
                        'kategori' => $value->kategori_file,
                        'uploader' => $value->nama,
                        'tanggal_upload' => $value->created_at,
                        'aksi' => $aksi
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
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function getFileBy(Request $request){
        $tb = $request->tb;
        $nama = $request->nama;
        $ekstensi= $request->ekstensi;
        $uploader = $request->uploader;
        $tanggal = $request->tanggal;
        $deskripsi = $request->deskripsi;
        $kategori = $request->kategori;
        $limit = is_null($request["length"]) ? 25 : $request["length"];
        $offset = is_null($request["start"]) ? 0 : $request["start"];
        $dirs = array("asc", "desc");
        $resultData = array();
        $data_arr    = [
            'limit' => $limit,
            'offset' => $offset,
            'dirs' => $dirs,
        ];

        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $nik = $get_session['username'];

        if (validateSessionToken($get_session_token)) {
            $tb_file =  DB::table('repositori')
            ->join('v_users_all', 'repositori.nik_pegawai', '=', 'v_users_all.username')
            ->select(DB::raw('repositori.*, v_users_all.nama as nama'));
            
            if($tb == 'my'){
                if (!is_null($nama)) {
                    $tb_file = $tb_file
                        ->where('repositori.nama_file', 'iLIKE', '%'.$nama.'%');
                } if (!is_null($ekstensi)) {
                    $tb_file = $tb_file
                        ->where('repositori.format_file', 'iLIKE', '%'.$ekstensi.'%');
                } if (!is_null($uploader)) {
                    $tb_file = $tb_file
                        ->where('v_users_all.nama', 'iLIKE', '%'.$uploader.'%');
                } if (!is_null($tanggal)) {
                    $tb_file = $tb_file
                        ->where('repositori.created_at', 'iLIKE', '%'.$tanggal.'%');
                }
                if (!is_null($deskripsi)) {
                    $tb_file = $tb_file
                        ->where('repositori.deskripsi_file', 'iLIKE', '%'.$deskripsi.'%');
                }
                if (!is_null($kategori)) {
                    $tb_file = $tb_file
                        ->where('repositori.kategori_file', 'iLIKE', '%'.$kategori.'%');
                }
                $tb_file =  $tb_file
                    ->where('repositori.nik_pegawai', '=', $nik);
                $init= 'my';
            }else if($tb == 'all'){
                if (!is_null($nama)) {
                    $tb_file = $tb_file
                        ->where('repositori.nama_file', 'iLIKE', '%'.$nama.'%');
                } 
                if (!is_null($ekstensi)) {
                    $tb_file = $tb_file
                        ->where('repositori.format_file', 'iLIKE', '%'.$ekstensi.'%');
                } 
                if (!is_null($uploader)) {
                    $tb_file = $tb_file
                        ->where('v_users_all.nama', 'iLIKE', '%'.$uploader.'%');
                } 
                if (!is_null($tanggal)) {
                    $tb_file = $tb_file
                        ->where('repositori.created_at', 'iLIKE', '%'.$tanggal.'%');
                }
                if (!is_null($deskripsi)) {
                    $tb_file = $tb_file
                        ->where('repositori.deskripsi_file', 'iLIKE', '%'.$deskripsi.'%');
                }
                if (!is_null($kategori)) {
                    $tb_file = $tb_file
                        ->where('repositori.kategori_file', 'iLIKE', '%'.$kategori.'%');
                }

                $init= 'all';
            }
            $total_data = $tb_file->count();
            $repositori = $tb_file
                ->orderBy('repositori.created_at', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            $datas = [];

            $no = $offset + 1;

            if (count($repositori) > 0) {
                foreach ($repositori as $value) {
                    $filepath_temp = "'".$value->filepath."'";
                    $fullname = "'".$value->nama_file.".".$value->format_file."'";
                    $id = 'row_'.preg_replace('/\s+/', '_', $value->filepath);
                    $datas[] = array(
                        'DT_RowId' => $init."_".$id,
                        'no' => $no++,
                        'nama_file' => $value->nama_file,
                        'format_file' => $value->format_file,
                        'deskripsi' => $value->deskripsi_file,
                        'kategori' => $value->kategori_file,
                        'uploader' => $value->nama,
                        'tanggal_upload' => $value->created_at,
                        'aksi' => '<a type="button" href="'.url('repositori/download').'/'.$value->filepath.'" target="_blank" class="btn btn-primary btn-xs ms-1 mb-1"><i class="mdi mdi-cloud-download"></i></a>'
                        .'<button type="button"  onclick="addToCart('.$filepath_temp.')" class="btn btn-success btn-xs ms-1 mb-1"><i class="mdi mdi-checkbox-marked"></i></button>'
                        .'<button type="button" onclick="deleteclick('.$fullname.', '.$filepath_temp.')" class="btn btn-danger btn-xs ms-1 mb-1"><i class="mdi mdi-trash-can"></i></button>'
                    );
                }
            } else {
                $datas = array();
            }
            $recordsTotal = is_null($total_data) ? 0 : $total_data;
            $recordsFiltered = is_null($total_data) ? 0 : $total_data;
            $data = $datas;
            return response()->json(compact("data",  "recordsTotal", "recordsFiltered"));
        } else {
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function tambah(Request $request)
    {
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $get_session_username = $get_session['username'];
        
        $now = Carbon::now();

        $file_issues = $request->file('file_repositori');
        $kategori_file = $request->kategori_file;
        $deskripsi_file = $request->deskripsi_file;
        $file_issues_jumlah = is_null($file_issues) ? 0 : count($file_issues);
        $texts = array('script','<script>','<?','?>','{{','}}','<?php','cript');
        $accepted= array('doc','xls','docx','xlsx','pdf','jpg','jpeg','png','svg');
        for ($i = 0; $i < $file_issues_jumlah; $i++){
            $name = $file_issues[$i]->getClientOriginalName();
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $deskripsi_file[$i] = strip_tags($deskripsi_file[$i]);
            if (in_array(strtolower($ext), $accepted)){

            }else{
                return response()->json(['success' => 'Attachment file tidak dapat diupload', 'kode' => 401]);
            }
        }
        // for ($i = 0; $i < $file_issues_jumlah; $i++){
        //     // foreach($texts as $text){
        //         // dd($texts,strtolower($deskripsi_file[$i]),stripos(strtolower($deskripsi_file[$i]), $text));
        //         // if(stripos(strtolower($deskripsi_file[$i]), $text)==true){
        //         //     // dd("if",stripos(strtolower($deskripsi_file[$i]), $text));
        //         //     // dd($text);
        //         //     return response()->json(['success' => 'Attachment file tidak dapat diupload, periksa kolom isian dengan benar', 'kode' => 401]);
        //         // }else{
        //         //     // dd("else",stripos(strtolower($deskripsi_file[$i]), $text));
        //         //     // return response()->json(['success' => 'Attachment file tidak dsapat diupload, periksa kolom isian dengan benar', 'kode' => 401]);
        //         // }
        //     $deskripsi_file[$i] = strip_tags($deskripsi_file[$i]);
        //     // }
        // }

        if (validateSessionToken($get_session_token)) {
            for ($i = 0; $i < $file_issues_jumlah; $i++) {
                $filename_dengan_extension = $file_issues[$i]->getClientOriginalName();
                $filename_tanpa_extension = pathinfo($filename_dengan_extension, PATHINFO_FILENAME);
                $file_extension = $file_issues[$i]->getClientOriginalExtension();

                $name = $file_issues_jumlah[$i]->getClientOriginalName();
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                if (in_array(strtolower($ext), $accepted)) {
                } else {
                    return response()->json(['success' => 'Attachment file tidak dapat diupload', 'kode' => 401]);
                }

                $filepath = substr($now,2,2).substr($now,8,2).substr($now,11,2).substr($now,14,2).'_'.rand(1000, 9999).$filename_dengan_extension;
                $destinationPath = public_path() . '/repositori/';
                $file_issues[$i]->move($destinationPath, $filepath);

                $tambah_repositori_file = DB::table('repositori')
                    ->insert([
                        'nama_file' => $filename_tanpa_extension,
                        'format_file' => $file_extension,
                        'nik_pegawai' => $get_session_username,
                        'deskripsi_file' => $deskripsi_file[$i],
                        'kategori_file' => $kategori_file[$i],
                        'created_at' => $now,
                        'updated_at' => $now,
                        'filepath' => $filepath
                    ]);
            }

            return response()->json(['success' => 'Data Berhasil Disimpan', 'kode' => 201]);
        } else {

            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function download($filepath){
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];

        if (validateSessionToken($get_session_token)) {
        $data = DB::table('repositori')
                ->select(DB::raw('repositori.*'))
                ->where('repositori.filepath', '=', $filepath)
                ->first();
        $file_name = $data->nama_file.'.'.$data->format_file;
        $file = public_path() . "/repositori/$filepath";
        // file_get_contents($file);
        return response()->download($file, $file_name);
        }else{
            return response()->json(['success' => 'anda belum login', 'kode' => 401]);
        }
    }

    public function deleteFile($filepath){
        $get_session = Session::get('user_app');
        $get_session_token = $get_session['token'];
        $nik = $get_session['username'];

        if (validateSessionToken($get_session_token)) {
        $delete_data = DB::table('repositori')
            ->where('repositori.filepath', '=', $filepath)
            ->where('repositori.nik_pegawai', '=', $nik)
            ->delete();
            if($delete_data){
                $file_delete = public_path() . '/repositori/' . $filepath;
                File::delete($file_delete);
            }else{
                return response()->json(['success' => 'Data tidak sesuai, tidak dapat menghapus file', 'kode' => 401]);
            }
        return response()->json(['success' => 'Data Berhasil Dihapus', 'kode' => 201]);
        }else{
            return response()->json(['success' => 'Anda belum login', 'kode' => 401]);
        }
    }

    public function zipdownload(Request $request){
        $array = [];
        foreach($request->arr as $item){
            $array[] = rawurldecode($item);
        }
        // dd($array);
        $file_folder = public_path() . "/repositori/"; // folder untuk load file
        if(extension_loaded('zip')) {   //memeriksa ekstensi zip
            if(isset($array) and count($array) > 0) {   //memeriksa file yang dipilih
                $zip = new \ZipArchive(); // Load zip library  
                $zip_name = "repositori_helpdesk_".Date('Y-m-d').rand(1000, 9999).".zip";  // nama Zip  
                if($zip->open($zip_name, \ZipArchive::CREATE) == TRUE){   //Membuka file zip untuk memuat file
                    $index=0;
                    foreach($array as $file){  
                        $new_filename = substr($file,strrpos($file,'/') + 1);
                        $zip->addFile($file_folder.$file, ++$index."_".substr($new_filename,12)); // Menambahkan files ke zip 
                        // dd($file,'22120955_8206UAT Script Modul 125+RTM.docx');
                    } 
                    $zip->close(); 
                    if(file_exists($zip_name)){  // Unduh ZIP
                        header('Content-type: application/zip'); 
                        header('Content-Disposition: attachment; filename="'.$zip_name.'"'); 
                        readfile($zip_name);  
                        unlink($zip_name); 
                    }else{
                        return response()->json(['Eror' => 'File ZIP tidak ditemukan', 'kode'=>401]);
                    }
                }else{
                    return response()->json(['Eror' => 'Gagal memuat temp ZIP', 'kode' => 401]);
                }
            }else{ 
                return response()->json(['Eror' => 'Tidak Ada File dipilih', 'kode' => 401]);
            } 
        } else { 
            return response()->json(['Error' => 'Ekstensi ZIP Tidak Ada', 'kode' => 401]);
        } 
    }
}