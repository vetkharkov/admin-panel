<?php

namespace App\Http\Controllers\AdminZone\Admin;


use Illuminate\Http\Request;
use MetaTag;


class SearchController extends AdminBaseController
{
    /** Show result */
    public function index(Request $request)
    {
        $query = trim($request->search);

        $products = \DB::table('products')
            ->where('title', 'LIKE', '%' . $query . '%')
            ->get()
            ->all();

        $currency = \DB::table('currencies')
            ->where('base', '=', '1')
            ->first();

        MetaTag::setTags(['title' => "Результаты поиска"]);

        return view('admin-panel.admin.search.result', compact('query', 'products', 'currency'));
    }

    /** AJAX search */
    public function search(Request $request)
    {
        $search = $request->get('term');

        $result = \DB::table('products')
            ->select('title')
            ->where('title', 'LIKE', '%' . $search . '%')
            ->pluck('title');

        return response()->json($result);
    }


}
