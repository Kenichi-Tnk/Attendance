<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceCorrectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'required|date_format:H:i|after:clock_in',
            'rests.*.rest_start' => 'nullable|date_format:H:i|after_or_equal:clock_in|before_or_equal:clock_out',
            'rests.*.rest_end' => 'nullable|date_format:H:i|after_or_equal:rests.*.rest_start|before_or_equal:clock_out',
            'note' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'clock_out.after' => '出勤時間もしくは退勤時間が不適切な値です。',
            'rests.*.rest_start.after_or_equal' => '休憩開始時間は出勤時間以降である必要があります。',
            'rests.*.rest_start.before_or_equal' => '休憩開始時間は退勤時間以前である必要があります。',
            'rests.*.rest_end.after_or_equal' => '休憩終了時間は休憩開始時間以降である必要があります。',
            'rests.*.rest_end.before_or_equal' => '休憩終了時間は退勤時間以前である必要があります。',
            'note.required' => '備考を記入してください。',
        ];
    }
}
