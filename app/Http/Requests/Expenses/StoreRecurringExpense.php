<?php

namespace App\Http\Requests\Expenses;

use App\Http\Requests\CoreRequest;

class StoreRecurringExpense extends CoreRequest
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
        $rotation = $this->get('rotation');

        $rules = [
            'item_name' => 'required',
            'price' => 'required|numeric',
            'billing_cycle' => 'required',
        ];

        return $rules;
    }

}
