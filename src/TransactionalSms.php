<?php
namespace AndreaLagaccia\Sendinblue;

use AndreaLagaccia\Sendinblue\Sendinblue;
use Illuminate\Support\Facades\DB;

class TransactionalSms extends Sendinblue
{
    protected $url;

    public function __construct()
    {
        parent::__construct();

        $this->url = $this->api_base_url . 'transactionalSMS/sms/';
    }

    public function send($number, $content)
    {
        $method_url = $this->url;

        $res = \Http::withHeaders($this->api_headers)->post($method_url, [
                'type' => 'transactional',
                'unicodeEnabled' => false,
                'sender' => $this->sms_sender_name,
                'recipient' => $number,
                'content' => $content,
                'webUrl' => $this->sms_webhook,
            ]);

        if ( $this->setting_sms_counter_column_name ) {
            DB::table($this->setting_table_name)->where("{$this->setting_column_name}", "{$this->setting_sms_counter_column_name}")->update([
                "{$this->setting_sms_counter_value_name}" => $res->remaining_credit,
            ]);
        }

        return $res->object();
    }
}
