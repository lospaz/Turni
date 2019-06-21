<?php

namespace Modules\Shift\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shift\Models\Activity;
use Modules\Shift\Models\ActivityHasTasks;
use Modules\Shift\Models\Local;
use Modules\Shift\Models\Task;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Activity::orderBy('name')->with(['local', 'tasks'])->paginate(10);

        return view('Shift::activities.index', [
            'activities' => $activities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locals = Local::orderBy('name')->get();
        $tasks = Task::orderBy('name')->get();
        return view('Shift::activities.create', [
            'locals' => $locals,
            'tasks' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $activity = new Activity;
        $activity->fill($request->except('_token', 'tasks'));
        $activity->save();

        if($activity){
            foreach ($request->tasks as $task) {
                $task = Task::find($task);
                if($task != null)
                    ActivityHasTasks::create(['activity_id' => $activity->id, 'task_id' => $task->id]);
            }
        }

        flash()->success('Attività creata con successo.');
        return redirect()->route('shifts.activities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);

        $locals = Local::orderBy('name')->get();
        $tasks = Task::orderBy('name')->get();

        return view('Shift::activities.edit', [
            'activity' => $activity,
            'locals' => $locals,
            'tasks' => $tasks
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->fill($request->except('_token', 'tasks'));
        $activity->save();

        if($activity){
            ActivityHasTasks::where('activity_id', $activity->id)->delete();
            foreach ($request->tasks as $task) {
                $task = Task::find($task);
                if($task != null)
                    ActivityHasTasks::create(['activity_id' => $activity->id, 'task_id' => $task->id]);
            }
        }

        flash()->success('Attività salvata con successo.');
        return redirect()->route('shifts.activities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        ActivityHasTasks::where('activity_id', $activity->id)->delete();
        $activity->delete();

        flash()->success('Attività eliminata con successo.');
        return redirect()->route('shifts.activities.index');
    }
}
