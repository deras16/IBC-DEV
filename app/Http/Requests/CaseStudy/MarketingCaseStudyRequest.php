<?php

namespace App\Http\Requests\CaseStudy;

use App\Enums\MarketingTopic;
use App\Enums\SpaceType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MarketingCaseStudyRequest extends FormRequest
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
            'client_description' => ['required', 'string', 'min:5', 'max:100'],
            'marketing_case_topic' => ['required', 'string', Rule::enum(MarketingTopic::class)],
            'date' => ['required', 'date'],
            'views' => ['required', 'numeric', 'gt:0'],
            'impressions' => ['required', 'numeric', 'gt:0'],
            'listeners' => ['required', 'numeric', 'gt:0'],
            'followers' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
