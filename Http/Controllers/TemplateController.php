<?php

namespace Modules\Shift\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Shift\Models\Activity;
use Modules\Shift\Models\Template;
use Modules\Shift\Models\TemplateHasActivities;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::orderBy('name')->paginate(10);

        return view('Shift::templates.index', [
            'templates' => $templates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activities = Activity::orderBy('name')->get();
        return view('Shift::templates.create', [
            'activities' => $activities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $template = new Template;
        $template->fill($request->except('_token', 'activities'));
        $template->save();

        if($template){
            foreach ($request->activities as $activity) {
                $activity = Activity::find($activity);
                if($activity != null)
                    TemplateHasActivities::create(['template_id' => $template->id, 'activity_id' => $activity->id]);
            }
        }

        flash()->success('Modello creato con successo');
        return redirect()->route('shifts.templates.index');
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
        $template = Template::findOrFail($id);
        $activities = Activity::orderBy('name')->get();
        return view('Shift::templates.edit', [
            'activities' => $activities,
            'template' => $template
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
        $template = Template::findOrFail($id);
        $template->fill($request->except('_token', 'activities'));
        $template->save();

        if($template){
            TemplateHasActivities::where('template_id', $template->id)->delete();
            foreach ($request->activities as $activity) {
                $activity = Activity::find($activity);
                if($activity != null)
                    TemplateHasActivities::create(['template_id' => $template->id, 'activity_id' => $activity->id]);
            }
        }

        flash()->success('Modello salvato con successo');
        return redirect()->route('shifts.templates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = Template::findOrFail($id);
        TemplateHasActivities::where('template_id', $template->id)->delete();
        $template->delete();

        flash()->success('Modello eliminato con successo.');
        return redirect()->route('shifts.templates.index');
    }
}
