<?php

namespace App\Http\Requests\CaseStudy;

use App\Enums\SpaceTopic;
use App\Enums\SpaceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CaseStudyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'min:5' , 'max:50'],
            'space_title' => ['required', 'string', 'min:5', 'max:50'],
            'space_topic' => ['required', 'string', Rule::enum(SpaceTopic::class)],
            'space_type' => ['required', 'string', Rule::enum(SpaceType::class)],
            'date' => ['required', 'date'],
            'views' => ['required', 'numeric', 'gt:0'],
            'impressions' => ['required', 'numeric', 'gt:0'],
            'listeners' => ['required', 'numeric', 'gt:0'],
            'followers' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
