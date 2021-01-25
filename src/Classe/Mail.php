<?php

namespace App\Classe;
use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key ='18507148a543d892ac6bc090fd331a13';
    private $api_key_secret = '6541a63c369fd5f888a864b526ee9cb1';

    public function send($to_email, $to_name, $subject, $content) 
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        // $mj = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'),true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "morgane.mottey@gmail.com",
                        'Name' => "MM"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 2292854,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}