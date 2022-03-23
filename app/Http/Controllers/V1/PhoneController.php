<?php

namespace App\Http\Controllers\V1;

use App\Events\ReloadDataEvent;
use App\Http\Requests\PhoneCreateRequest;
use App\Http\Requests\PhoneEditRequest;
use App\Models\Phone;

class PhoneController extends BaseController
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Routing\ResponseFactory
     */
    public function index()
    {
        $phone = Phone::get();

        return $this->returnSuccess($phone);
    }

    /**
     * @param \App\Http\Requests\PhoneCreateRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Routing\ResponseFactory
     */
    public function store(PhoneCreateRequest $request)
    {
        Phone::create($request->validated());

        event(new ReloadDataEvent('data'));

        return $this->returnSuccess([]);
    }

    /**
     * @param \App\Http\Requests\PhoneEditRequest $request
     * @param $id
     * @return void
     */
    public function update(PhoneEditRequest $request, $id)
    {
        $phone = Phone::find($id);
        $phone->update($request->validated());

        event(new ReloadDataEvent('data'));

        return $this->returnSuccess([]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response|\Illuminate\Routing\ResponseFactory
     */
    public function delete($id)
    {
        Phone::destroy($id);

        event(new ReloadDataEvent('data'));

        return $this->returnSuccess([]);
    }

    /**
     * @return \Illuminate\Http\Response|\Illuminate\Routing\ResponseFactory
     */
    public function auto()
    {
        $data = [];
        for ($i = 0; $i < 15; $i++) {
            $data[] = [
                'phone_number' => rand(6280000000000, 6289999999999),
                'provider' => randomArray(['XL', 'TELKOMSEL', 'TRI', 'INDOSAT']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Phone::insert($data);

        event(new ReloadDataEvent('data'));
        return $this->returnSuccess([]);
    }
}
