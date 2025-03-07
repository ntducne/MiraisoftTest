<?php

namespace App\Http\Controllers;

use App\Http\Requests\HtmlFileRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;

class HtmlFileController extends Controller
{
    public function getHtmlFile(HtmlFileRequest $request): JsonResponse
    {
        try {
            $file = $request->input('file');
            $appEnv = $request->input('app_env');
            $contractServer = $request->input('contract_server');
            $appEnvMap = [
                0 => 'AWS',
                1 => 'K5',
                2 => 'T2'
            ];
            $contractServerMap = [
                0 => 'app1',
                1 => 'app2'
            ];
            $filePath = "html/{$file}_" . $appEnvMap[$appEnv] . "_" . $contractServerMap[$contractServer] . ".html";
            if (!Storage::disk('public')->exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'filename' => "",
                    'message' => 'Seal Info response false',
                ], 404);
            }
            $htmlContent = Storage::disk('public')->get($filePath);
            return response()->json([
                'success' => true,
                'filename' => $filePath,
                'content' => $htmlContent,
                'message' => 'Seal Info response successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error retrieving HTML file: ' . $e->getMessage(), [
                'file' => $request->input('file'),
                'app_env' => $request->input('app_env'),
                'contract_server' => $request->input('contract_server'),
                'exception' => $e
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the file.',
            ], 500);
        }
    }
}
