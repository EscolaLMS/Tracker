<?php

namespace EscolaLms\Tracker\Http\Requests;

use EscolaLms\Tracker\Models\TrackRoute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class TrackRouteListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('list', TrackRoute::class);
    }

    public function rules(): array
    {
        return [];
    }
}
