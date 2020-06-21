<?php
namespace Controller;

use Core\Controller;
use Core\Request;
use Models\Work;

class WorkController extends Controller
{
    /**
     * Display a listing of the work.
     *
     * @return view
     */
    public function index()
    {
        $works = Work::orderBy('id', 'desc')->get();

        return view('work/index', [
            'works' => $works,
        ]);
    }

    /**
     * Display create work form.
     * 
     * @return view
     */
    public function create()
    {
        return view('work/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return redirect to work list
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return view
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  string $id
     *
     * @return redirect to work list
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return redirect to work list
     */
    public function delete()
    {
        $id = Request::input('id');
        $work = Work::where('id', '=', $id)->delete();
        if (Request::xmlhttprequest()) {
            echo json_encode(true);
            die();
        }

        return redirect('/work');
    }
}
