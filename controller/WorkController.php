<?php
namespace Controller;

use Core\Controller;
use Core\Request;
use Models\Work;

class WorkController extends Controller {

    public function index()
    {
        $works = Work::get();

        return view('work/index', [
            'works' => $works,
        ]);
    }

    public function create()
    {
        return view('work/create');
    }

    public function store()
    {
        $data = (array) Request::only([
            'work_name',
            'start_date',
            'end_date',
            'status',
        ]);
        $work = Work::create($data);

        return redirect('/work');
    }

    public function edit($id)
    {
        $work = Work::where('id', '=', $id)->first();
        if (!$work) {
            return null;
        }

        return view('work/edit', [
            'work' => $work,
        ]);
    }

    public function update($id)
    {
        $data = (array) Request::only([
            'work_name',
            'start_date',
            'end_date',
            'status',
        ]);
        $work = Work::where('id', '=', $id)->update($data);

        return redirect('/work');
    }
}
