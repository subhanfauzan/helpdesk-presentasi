<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class getPerbaruiPegawai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getPerbaruiPegawai:perbaruiPegawai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'untuk memperbarui pegawai pada plikasi helpdesk TI';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app('App\Http\Controllers\pegawaiController')->getPerbaruiPegawai();
    }
}
