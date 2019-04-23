<?php
/** 
 * @author Arvin Jay Sumalbag <ajsumalbag14@gmail.com>
 * VS Code
 * PHP Version 7.2.1
 * 2019-04-23 2:44
 */
namespace App\Modules\User\Profile\Services;

use Curl;

class SendMailService 
{

    public function __construct()
    {
        //
    }

    public function handle($userObject)
    {
        
        $from = 'asumalbag@yondu.com';
        $from_name = 'Test From';
        $to = 'ajsumalbag14@gmail.com';
        $subject = 'Test Email';
        $message = $userObject->hint;

        $url = "https://api.mailgun.net/v3/sandbox4534388d52404e458a3514b78e3f9704.mailgun.org/messages";
        $pwd = "api:key-b380a2da121554d1f343dcbbfd68040e-dc5f81da-e04d2530";
        //$url = "https://api.mailgun.net/v3/mailgun.yondu.com/messages";
        //$pwd = "api:key-8sj2icezptojx-9k-kj3bjo6uukaluk9";
        $fields = array(
            'from' => $from_name." ".$from,
            'to' => $to,
            'subject' => $subject,
            'html' => $message   
        );

        $response =  $this->_send_curl_request($url, $fields, $pwd);

        $data = $this->_JSON_parser($response);

        if (!isset($data->id)) {
            \Log::info('Mailer Failed');
        } else {
            \Log::info('Mail sending success');
        }

    }

    private function _send_curl_request($url, $params, $pwd)
    {
        $response = Curl::to($url)->withOption('USERPWD', $pwd)->withData($params)->post();
        return $response;
    }

    private function _JSON_parser($string)
    {
        return json_decode($string);
    }
}
?>