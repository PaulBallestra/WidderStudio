<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\AclBundle\Entity\Car;

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
            'selectedDate' => 'required|after:today' //RULES qu'il y ait bien une date, et qu'elle soit supérieur à aujourd'hui
        ];
    }
}
