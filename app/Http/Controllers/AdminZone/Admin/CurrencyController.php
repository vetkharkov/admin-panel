<?php

namespace App\Http\Controllers\AdminZone\Admin;

use App\Http\Requests\AdminCurrencyAddRequest;
use App\Models\Admin\Currency;
use App\Repositories\Admin\CurrencyRepository;
use MetaTag;


class CurrencyController extends AdminBaseController
{
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
    }

    public function index()
    {
        $currency = $this->currencyRepository->getAllCurrency();

        MetaTag::setTags(['title' => 'Валюта магазина']);

        return view('admin-panel.admin.currency.index', compact('currency'));
    }

    public function currencyAdd()
    {
        MetaTag::setTags(['title' => 'Добавление валюты']);

        return view('admin-panel.admin.currency.add');
    }

    public function currencyStore(AdminCurrencyAddRequest $request)
    {
        $data = $request->input();
        $data['code'] = strtoupper($data['code']);

        $currency = (new Currency())->create($data);

        if ($request->base == 'on') {
            $this->currencyRepository->switchBaseCurr();
            $currency->base = '1';
        }

        $currency->save();

        if ($currency) {
            return redirect()
                ->route('adminzone.admin.currency.add')
                ->with(['success' => 'Валюта добавлена']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка добавления валюты'])
                ->withInput();
        }

    }


    public function currencyEdit($id)
    {
        $currency = $this->currencyRepository->getInfoCurrency($id);

        MetaTag::setTags(['title' => 'Редактироание валюты']);

        return view('admin-panel.admin.currency.edit', compact('currency'));
    }

    public function currencyUpdate(AdminCurrencyAddRequest $request, $id)
    {
        $currency = Currency::find($id);

        $currency->title        = $request->title;
        $currency->code         = strtoupper($request->code);
        $currency->symbol_left  = $request->symbol_left;
        $currency->symbol_right = $request->symbol_right;
        $currency->value        = $request->value;
        $currency->base         = $request->base ? '1' : '0';

        $currency->save();

        if ($currency) {
            return redirect()
                ->route('adminzone.admin.currency.edit', $id)
                ->with(['success' => 'Валюта изменена']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка изменения валюты'])
                ->withInput();
        }
    }

    public function currencyDelete($id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => "Запись с id = [{$id}] не найдена"]);
        }

        $delete = $this->currencyRepository->deleteCurrency($id);

        if ($delete) {
            return redirect()
                ->route('adminzone.admin.currency.index')
                ->with(['success' => 'Валюта удалена']);
        } else {
            return back()
                ->withErrors(['msg' => 'Ошибка удаления валюты'])
                ->withInput();
        }
    }
}
