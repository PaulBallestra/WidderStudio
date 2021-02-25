<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationFormRequest extends FormRequest
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
            'email' => 'required|email', //RULES que l'email est bien renseigné et qu'il soit un email
            'datepicker' => 'required|after:today' //RULES qu'il y ait bien une date, et qu'elle soit supérieur à aujourd'hui
        ];
    }
}
