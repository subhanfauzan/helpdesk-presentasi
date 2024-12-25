<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
// use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use File;
use Response;
use URL;
use Illuminate\Support\Facades\Redirect;
use Session;

class liburNasionalController extends Controller
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
        $data['judul'] = "National Holiday";
        return view('pages.libur_nasional.index', $data);
    }

    public function getLiburNasional()
    {
        $m_libur_nasional = DB::table('m_libur_nasional')
            ->select(DB::raw("m_libur_nasional.*"))
            ->get();

        return response()->json(['kode' => 201, 'success' => 'Data Berhasil Dikirim', 'data' => $m_libur_nasional]);
    }

    public function tambah(Request $request)
    {
        // dd($request->all());
        $tanggal_libur_nasional = $request->tanggal_libur_nasional;
        $nama_libur_nasional = $request->nama_libur_nasional;
        $tambah_m_libur_nasional = DB::table('m_libur_nasional')
            ->insert([
                'nama_libur_nasional' => $nama_libur_nasional,
                'tgl_libur_nasional' => $tanggal_libur_nasional,
                'created_at' => Carbon::now()
            ]);

        $m_libur_nasional = DB::table('m_libur_nasional')
            ->select(DB::raw("m_libur_nasional.*"))
            ->get();

        $issues_update = DB::table('issues')
            ->select(DB::raw("issues.id as id, issues.tanggal_batas_issues as batas"))
            ->where('tanggal_pembuatan_issues', '<=', substr($tanggal_libur_nasional,0,10)." 23:59:59")
            ->where('tanggal_batas_issues', '>=', substr($tanggal_libur_nasional,0,10)." 00:00:00")
            ->get();

        if(!$issues_update->isEmpty()){
            foreach ($issues_update as $item) {
                $batas = substr($item->batas,0,10);
                $day = date('D', strtotime($batas));
                $libur = DB::table('m_libur_nasional')
                ->select(DB::raw("m_libur_nasional.id"))
                ->where('m_libur_nasional.tgl_libur_nasional', '=', $batas)
                ->get();
                $index = 0;
                do {
                    if($day == "Fri"){
                        //tambah 3 hari
                        $index = $index+3;
                        $batas = Date('Y-m-d',strtotime("+3 day", strtotime($batas)));
                    }else if($day == "Sat"){
                        //tambah 2 hari
                        $index = $index+2;
                        $batas = Date('Y-m-d',strtotime("+2 day", strtotime($batas)));
                    }else{
                        //tambah 1 hari (hari biasa)
                        $index = $index+1;
                        $batas = Date('Y-m-d',strtotime("+1 day", strtotime($batas)));
                    }

                    $day = date('D', strtotime($batas));
                    $libur = DB::table('m_libur_nasional')
                    ->select(DB::raw("m_libur_nasional.id"))
                    ->where('m_libur_nasional.tgl_libur_nasional', '=', $batas)
                    ->get();
                    
                } while ($day == "Sat" || $day == "Sun" || !$libur->isEmpty());

                DB::table('issues')
                    ->where('id', $item->id)
                    ->update(['tanggal_batas_issues' => Date('Y-m-d H:i:s',strtotime("+".$index." day", strtotime($item->batas)))]);
            }
        }     
        
        return response()->json(['kode' => 201, 'success' => 'Data Berhasil Dikirim', 'data' => $m_libur_nasional]);
    }

    public function delete(Request $request, $id)
    {
        // dd($request->all());
        // dd($id);
        $tanggal_libur_nasional = DB::table('m_libur_nasional')
        ->select(DB::raw("m_libur_nasional.tgl_libur_nasional as tgl"))
        ->where('m_libur_nasional.id', '=', $id)
        ->get()
        ->first();

        $issues_update = DB::table('issues')
        ->select(DB::raw("issues.id as id, issues.tanggal_batas_issues as batas"))
        ->where('tanggal_pembuatan_issues', '<=', substr($tanggal_libur_nasional->tgl,0,10)." 23:59:59")
        ->where('tanggal_batas_issues', '>=', substr($tanggal_libur_nasional->tgl,0,10)." 00:00:00")
        ->get();

    if(!$issues_update->isEmpty()){
        foreach ($issues_update as $item) {
            $batas = substr($item->batas,0,10);
            $day = date('D', strtotime($batas));
            $libur = DB::table('m_libur_nasional')
            ->select(DB::raw("m_libur_nasional.id"))
            ->where('m_libur_nasional.tgl_libur_nasional', '=', $batas)
            ->get();
            $index = 0;
            
            do {
                if($day == "Mon"){
                    //tambah 3 hari
                    $index = $index+3;
                    $batas = Date('Y-m-d',strtotime("-3 day", strtotime($batas)));
                }else if($day == "Sun"){
                    //tambah 2 hari
                    $index = $index+2;
                    $batas = Date('Y-m-d',strtotime("-2 day", strtotime($batas)));
                }else{
                    //tambah 1 hari (hari biasa)
                    $index = $index+1;
                    $batas = Date('Y-m-d',strtotime("-1 day", strtotime($batas)));
                }

                $day = date('D', strtotime($batas));
                $libur = DB::table('m_libur_nasional')
                ->select(DB::raw("m_libur_nasional.id"))
                ->where('m_libur_nasional.tgl_libur_nasional', '=', $batas)
                ->get();
                
            } while ($day == "Sat" || $day == "Sun" || !$libur->isEmpty());

            DB::table('issues')
                ->where('id', $item->id)
                ->update(['tanggal_batas_issues' => Date('Y-m-d H:i:s',strtotime("-".$index." day", strtotime($item->batas)))]);
        }
    }

        $delete_m_kategori = DB::table('m_libur_nasional')
            ->where('m_libur_nasional.id', '=', $id)
            ->delete();

        $m_libur_nasional = DB::table('m_libur_nasional')
            ->select(DB::raw("m_libur_nasional.*"))
            ->get();

        return response()->json(['kode' => 201, 'success' => 'Data Berhasil Dikirim', 'data' => $m_libur_nasional]);
    }
}
