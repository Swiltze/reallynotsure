<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class StreamKeyController extends Controller
{

protected $fullPath;

    public function __construct()
    {
        $this->fullPath = '/var/www/html/live.goldbudz.com/public/stream/hls'; // Change this to the desired full path
    }


public function validateStreamKey(Request $request)
{
    // Log the entire request payload
    Log::info('Stream Key Validation Request:', $request->all());

    // Retrieve the stream key from the request
    $streamKey = $request->input('stream_key');

    // Log the received stream key
    Log::info('Stream key received: ' . $streamKey);

    // Find the user with the provided stream key
    $baseStreamKey = explode('-', $streamKey)[0];
    $user = User::where('stream_key', $baseStreamKey)->first();

    // Log the user retrieval result
    Log::info('User retrieved: ' . ($user ? $user->name : 'none'));

    // Check if a user with the provided stream key exists
    if ($user) {
        if (File::isDirectory($this->fullPath)) {
            $files = File::files($this->fullPath);

		foreach (Storage::files($this->fullPath) as $file) {
    if (Storage::mimeType($file) === 'application/x-mpegURL') {
        $streamKey = pathinfo($file->getRealPath(), PATHINFO_FILENAME);

        Log::info("Stream key: $streamKey");

        $apiEndpoint = "https://goldbudz.com/api/validate_stream_key";

        $client = new Client();
        $response = $client->post($apiEndpoint, ['form_params' => ['stream_key' => $streamKey]]);
        $body = $response->getBody();
        $json = json_decode($body, true);

        Log::info("API response: " . json_encode($json));

        if ($json['valid']) {
            $username = $json['username'];

            Log::info("Renaming to $username.m3u8");
            $newPath = $file->getPath() . '/' . $username . '.m3u8';
            Storage::move($file, $newPath);

            foreach (Storage::files($file->getRealPath()) as $sfile) {
                if (Storage::mimeType($sfile) === 'video/MP2T') {
                    Log::info("Renaming to $username-${sfile->getBasename()}");
                    $newPath = $sfile->getPath() . '/' . "$username-${sfile->getBasename()}";
                    Storage::move($sfile, $newPath);
                }
            }

            break;
        }
    }
}

        } else {

		if ($filename->isM3u8()) {
    $streamKey = $filename->getBasename('.m3u8');

    Log::info("Stream key: $streamKey");

    $apiEndpoint = "https://goldbudz.com/api/validate_stream_key";

    $client = new Client();
    $response = $client->post($apiEndpoint, ['form_params' => ['stream_key' => $streamKey]]);
    $body = $response->getBody();
    $json = json_decode($body, true);
    Log::info("API response:: " . json_encode($json));

    if ($json['valid']) {
        $username = $json['username'];

        Log::info("Renaming to $username.m3u8");
        $newPath = $filename->getPath() . '/' . $username . '.m3u8';
        $filename->move($newPath);

        foreach ($filename->getRelativeFiles() as $sfile) {
            if ($sfile->isTs()) {
                Log::info("Renaming to $username-${sfile->getBasename()}");
                $newPath = $sfile->getPath() . '/' . "$username-${sfile->getBasename()}";
                $sfile->move($newPath);

            }
        }
    }
}


        }

        return [
            "valid" => true,
            "username" => $user->name
        ];
    }

    return [
        "valid" => false,
        "message" => "User not found with stream key: $streamKey"
    ];
}


    public function generate(Request $request)
    {
        $user = auth()->user();
        $user->generateStreamKey();
        return response()->json(['stream_key' => $user->stream_key]);
    }

    public function reset(Request $request)
    {
        $user = auth()->user();
        $user->resetStreamKey();
        return response()->json(['stream_key' => $user->stream_key]);
    }



}
