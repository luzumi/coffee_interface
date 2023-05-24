<?php

namespace App\Services;

use App\Models\CoffeeVariety;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;


class VarietiesService
{
    public function update(Request $request, $id): Redirector|Application|RedirectResponse
    {
        $cat = CoffeeVariety::find($id);

        $cat->coffee_name = $request->input('title');
        $cat->credit_cost = $request->input('cost');
        $cat->coffee_code = $request->input('code');
        $cat->coffee_description = $request->input('description');
        //$cat->coffee_image = $request->input('coffee_image');

        $cat->save();

        return redirect('admin/cats');
    }
}
