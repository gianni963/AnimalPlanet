<?php

namespace App\Http\Forms;

use App\Exceptions\ThrottleException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;



class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new \App\Models\Reply);
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException(
            'You are replying too frequently. Please wait 60 sec.'
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree',
        ];
    }
}