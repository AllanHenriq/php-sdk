<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\AccessToken;
use Carbon\Carbon;

// possibly moving these requirements when migration moves
use App\Models\Category;
use App\Models\Group;
use App\Models\Product;
use App\Models\ProductCondition;

class TCGplayer
{
    public function __construct()
    {
        // define all of our variables, set base uri, initialize client
        $this->guzzle = new Client([
            'base_uri' => 'https://api.tcgplayer.com/' . env('TCG_VERSION')
        ]);
        $this->publicKey = env('TCG_PUBLIC_KEY');
        $this->privateKey = env('TCG_PRIVATE_KEY');
        $this->storeKey = $this->getStoreKey();
        // get headers, grab authorization token
        $this->headers = $this->getHeaders();
    }

    /**
     * Set headers for requests
     * @return array Contains all headers used on request
     */
    public function getStoreKey()
    {
        return 'storeKey';
    }

    /**
     * Set headers for requests
     * @return array Contains all headers used on request
     */
    public function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->refreshToken()->access_token
        ];
    }

    /**
     * Refreshes an access token or creates a new one if none exists
     * @return AccessToken Model containing response of /token request
     */
    public function refreshToken()
    {
        // check if we have no token in our database or if our token expired
        if (empty($this->token) || $this->token->expires <= Carbon::now()) {
            // we only ever want one access token
            $token = AccessToken::first();

            // create our request body
            $requestBody = 'grant_type=client_credentials&client_id=' . $this->publicKey
                . '&client_secret=' . $this->privateKey;
            $response = $this->guzzle->request('POST', '/token', ['body' => $requestBody]);
            $response = json_decode($response->getBody()->getContents(), true);

            // create new token if we don't have one, update existing if we do
            if (empty($token)) {
                $token = AccessToken::create([
                    'access_token' => $response['access_token'],
                    'token_type' => $response['token_type'],
                    'expires_in' => $response['expires_in'],
                    'user_name' => $response['userName'],
                    'expires' => Carbon::parse($response['.expires']),
                    'issued' => Carbon::parse($response['.issued'])
                ]);
            } else {
                $token->update([
                    'access_token' => $response['access_token'],
                    'token_type' => $response['token_type'],
                    'expires_in' => $response['expires_in'],
                    'user_name' => $response['userName'],
                    'expires' => Carbon::parse($response['.expires']),
                    'issued' => Carbon::parse($response['.issued'])
                ]);
            }
            // set token to avoid making new database calls while repository is loaded
            $this->token = $token;
        }
        return $this->token;
    }
}
