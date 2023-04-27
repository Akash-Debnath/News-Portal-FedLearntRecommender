<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class OneDriveController extends Controller
{

    public function redirectToProvider()
    {
        return Socialite::driver('onedrive')->scopes(['files.readwrite.all'])->redirect();
    }


    public function handleProviderCallback()
    {
        $user = Socialite::driver('onedrive')->user();
        $accessToken = $user->token;
        // Save the token and use it to perform CRUD operations on OneDrive files
    }


    private function uploadFileToOnedrive($accessToken, $filename,$content)
    {
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        $file = $graph->createRequest('PUT',
        '/me/drive/root:/'.$filename.':/content')
        ->addHeaders(['Content-Type' => 'text/plain'])
        ->setBody($content)
        ->execute();
    }

    private function downloadFileFromOnedrive($accessToken, $filename)
    {
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        $fileContent = $graph->createRequest('GET','/me/drive/root:/'.$filename.':/content')->download();
        return $fileContent;
    }

}
