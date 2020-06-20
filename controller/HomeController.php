<?php
namespace Controller;

use Core\Controller;
use Models\Work;

class HomeController extends Controller {

    public function index() {
        // $works = Work::where('id', '=', 1)->first();
        $create = Work::create([
            'work_name' => 111,
            'start_date' => '2020-12-13 12:00:00',
            'end_date' => '2020-12-15 12:00:00',
            'status' => 2,
        ]);
        dd($create);
        return view('welcome');
    }
}