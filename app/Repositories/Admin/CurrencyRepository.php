<?php

namespace App\Repositories\Admin;


use App\Models\Admin\Currency;
use App\Repositories\CoreRepository;
use App\Models\Admin\Currency as Model;

class CurrencyRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAllCurrency()
    {
        $currency = $this->startConditions()->all();
        return $currency;
    }

    /** Switch base currensy = 0 */
    public function switchBaseCurr()
    {
        $id = Currency::where('base', '1')->get()->first();

        if ($id) {
            $id = $id->id;
            $new = Currency::find($id);
            $new->base = '0';
            $new->save();
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка!!! Базавой валюты НЕТ!'])
                ->withInput();
        }
    }

    /** Get info currency by id */
    public function getInfoCurrency($id)
    {
        $currency = $this->startConditions()->find($id);
        return $currency;
    }

    /** Delete currency by id */
    public function deleteCurrency($id)
    {
        $delete = $this->startConditions()->where('id', $id)->forceDelete();
        return $delete;
    }


}