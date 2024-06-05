<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudioStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:track,song,voice_note',
            'file' => 'required|file|mimes:mp3,flac,m4a,wav|max:20480', // Max 20MB
            'project_id' => 'required|integer',
        ];
    }
}
