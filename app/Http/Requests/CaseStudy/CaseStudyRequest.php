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
            'client_name' => ['required', 'string'],
            'space_topic' => ['required', 'string', Rule::enum(SpaceTopic::class)],
            'space_type' => ['required', 'string', Rule::enum(SpaceType::class)],
            'space_title' => ['required', 'string'],
            'date' => ['required', 'date'],
            'views' => ['required', 'numeric'],
            'impressions' => ['required', 'numeric'],
            'listeners' => ['required', 'numeric'],
            'followers' => ['required', 'numeric'],
        ];
    }
}
