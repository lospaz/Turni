<?php

namespace Modules\Shift\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShiftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->can('shift.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'startDate' => 'required|date_format:d/m/Y',
            'startHour' => 'required|date_format:H:i',
            'endDate' => 'required|date_format:d/m/Y',
            'endHour' => 'required|date_format:H:i',

            'users' => 'required|array',
            'users.*' => 'required|exists:users,id',

            'template_id' => 'nullable|this_or_that:activities|exists:templates,id',

            'activities' => 'nullable|this_or_that:template_id|array',
            'activities.*' => 'exists:activities,id',

        ];
    }

    public function messages()
    {
        return [
            'template.this_or_that' => 'Il campo modello è richiesto se nessuna attività è specificata.',
            'activities.this_or_that' => 'Il campo attività è richiesto se nessun modello è specificato.'
        ];
    }
}
