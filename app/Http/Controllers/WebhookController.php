<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $data = $request->json()->all();
        Log::info('Webhook received - incoming: ' . $data['user_id']);
        DB::table('rasp_users')->where('id', 1)->update(['user_id' => $data['user_id']]);

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function checkWebhook(Request $request)
    {
        // Verarbeiten Sie die Daten des Webhooks
        Log::alert(
            'Webhook received- check: ' .
            $request->getContent('name') . ' ' .
            $request->getContent('Channel_URL'));

        $data = session()->get('webhook_data');
        $viewData['name'] = $data['name'];
        $viewData['channel_url'] = $data['Channel_URL'];


        return redirect()->route('menu', compact('viewData'));
    }

    public function getWebhookData()
    {
        $data = DB::table('rasp_users')->first('user_id');
//        Log::info('Webhook received - getWebHookData: ' . $data->user_id);
        return response()->json(['data' => $data]);
    }
}
