<?php


class MessageSaveRequest extends FormRequest
{

    protected function rules()
    {
        return [
            'message' => ['required']
        ];
    }
}