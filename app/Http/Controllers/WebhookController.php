<?php

namespace App\Http\Controllers;

use App\Services\RaspUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function handleWebhook(Request $request)
    {
        $data = $request->json()->all();

        RaspUser::setRaspUser($data['user_id']);

        return response()->json(['status' => 'success', 'data' => $data]);
    }


    /**
     * @return JsonResponse
     */
    public function getWebhookData()
    {
        $rasp_user_id = RaspUser::getRaspUser();

        return response()->json(['data' => $rasp_user_id]);
    }


}
