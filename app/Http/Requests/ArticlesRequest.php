<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticlesRequest extends FormRequest
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
            'title'     =>['required'],
            'content'   =>['required','min:10'],
        ];
    }

    public function message(){
        return [

            'required'      => ':attribute must be required',
            'min'           => ':attirvute must be more than 10 Characters'
        ];
    }

    public function attributes()
    {
        return [
            'title'         => 'title(제목)',
            'content'       => 'content(본문)',
        ];
    }
}
