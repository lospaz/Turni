<?php

namespace Modules\Shift\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Shift\Http\Requests\ShiftRequest;
use Modules\Shift\Models\Activity;
use Modules\Shift\Models\Shift;
use Modules\Shift\Models\ShiftHasActivities;
use Modules\Shift\Models\ShiftHasUsers;
use Modules\Shift\Models\Template;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Shift::calendar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $start = Carbon::createFromTimestamp($request->start);
        $end = Carbon::createFromTimestamp($request->end);

        $activities = Activity::orderBy('name')->get();
        $template = Template::orderBy('name')->get();

        return view('Shift::calendar.create', [
            "startDate" => $start->format("d/m/Y"),
            "startHour" => $start->format("H:i"),
            "endDate" => $end->format("d/m/Y"),
            "endHour" => $end->format("H:i"),
            "activities" => $activities,
            "template" => $template
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftRequest $request)
    {
        $shift = new Shift;
        $shift->template_id = $request->template_id;
        $shift->start = Carbon::createFromFormat("d/m/Y H:i", "$request->startDate $request->startHour");
        $shift->end = Carbon::createFromFormat("d/m/Y H:i", "$request->endDate $request->endHour");
        $shift->save();

        if($request->has('activities') && $shift){
            foreach ($request->activities as $activity) {
                ShiftHasActivities::create([
                    'shift_id' => $shift->id,
                    'activity_id' => $activity
                ]);
            }
        }

        if($request->has('users') && $shift){
            foreach ($request->users as $user) {
                ShiftHasUsers::create([
                    'shift_id' => $shift->id,
                    'user_id' => $user
                ]);
            }
        }

        flash()->success("Il turno è stato creato con successo");
        return redirect()->route('shifts.calendar.index');

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
        if(!Auth::user()->can('shift.edit'))
            abort(403);

        $shift = Shift::findOrFail($id);
        $activities = Activity::orderBy('name')->get();
        $template = Template::orderBy('name')->get();

        return view('Shift::calendar.edit', [
            "shift" => $shift,
            "activities" => $activities,
            "template" => $template
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShiftRequest $request, $id)
    {
        if(!Auth::user()->can('shift.edit'))
            abort(403);

        $shift = Shift::findOrFail($id);
        $shift->template_id = $request->template_id;
        $shift->start = Carbon::createFromFormat("d/m/Y H:i", "$request->startDate $request->startHour");
        $shift->end = Carbon::createFromFormat("d/m/Y H:i", "$request->endDate $request->endHour");
        $shift->save();

        ShiftHasActivities::where('shift_id', $shift->id)->delete();
        if($request->has('activities') && $shift){
            foreach ($request->activities as $activity) {
                ShiftHasActivities::create([
                    'shift_id' => $shift->id,
                    'activity_id' => $activity
                ]);
            }
        }

        if($request->has('users') && $shift){
            ShiftHasUsers::where('shift_id', $shift->id)->delete();
            foreach ($request->users as $user) {
                ShiftHasUsers::create([
                    'shift_id' => $shift->id,
                    'user_id' => $user
                ]);
            }
        }

        flash()->success("Il turno è stato salvato con successo");
        return redirect()->route('shifts.calendar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('shift.delete'))
            abort(403);

        $shift = Shift::findOrFail($id);
        ShiftHasActivities::where('shift_id', $shift->id)->delete();
        ShiftHasUsers::where('shift_id', $shift->id)->delete();
        $shift->delete();

        flash()->success('Turno eliminato con successo.');
        return redirect()->route('shifts.calendar.index');
    }

    public function source(Request $request){
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        $shifts = Shift::join('shift_has_users', 'shifts.id', '=', 'shift_has_users.shift_id')
            ->join('users', 'shift_has_users.user_id', '=', 'users.id')
            ->whereDate('start', '>=', $start)
            ->with('activities', 'template')
            ->select(DB::raw('shifts.*, users.id as resourceId'))
            ->get();
        $s = [];
        foreach ($shifts as $shift) {
            $data = [
                "id" => $shift->id,
                "resourceId" => $shift->resourceId,
                "start" => $shift->start->format('Y-m-d H:i'),
                "end" => $shift->end->format('Y-m-d H:i'),
                "title" => self::getShiftTitle($shift)
            ];
            array_push($s, $data);
        }

        return response()->json($s);
    }

    public static function getShiftTitle($shift){
        if($shift->template !== null)
            return $shift->template->name;
        else
            return $shift->activities->pluck('name')->implode(', ');
    }

    public function shift($id){
        $shift = Shift::findOrFail($id);

        $view = view('Shift::calendar.show', [
            'shift' => $shift
        ])->render();

        return response()->json([
            'view' => $view,
            'edit' => Auth::user()->can('shift.edit'),
            'delete' => Auth::user()->can('shift.delete')
        ]);
    }
}
