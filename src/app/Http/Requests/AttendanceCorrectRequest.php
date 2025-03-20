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
            'rest_start' => 'nullable|date_format:H:i|before:clock_out|after:clock_in',
            'rest_end' => 'nullable|date_format:H:i|before:clock_out|after:rest_start',
            'note' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'clock_out.after' => '出勤時間もしくは退勤時間が不適切な値です。',
            'rest_start.after' => '休憩時間が勤務時間外です。',
            'rest_end.after' => '休憩時間が勤務時間外です。',
            'note.required' => '備考を記入してください。',
        ];
    }
}
