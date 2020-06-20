<?php
namespace Controller;

use Core\Controller;
use Core\Request;
use Models\Work;

class CalendarController extends Controller {

    public function index()
    {
        $works = Work::get();

        return view('calendar/index', [
            'works' => $works,
        ]);
    }
}
