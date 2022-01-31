<?php
namespace AndreaLagaccia\Sendinblue;

use AndreaLagaccia\Sendinblue\Sendinblue;

class Contact extends Sendinblue
{
    protected $url;

    public function __construct()
    {
        parent::__construct();

        $this->url = $this->api_base_url . 'contacts/';
    }

    public function create($email, $ATTRIBUTES, $list_id = null)
    {
        $method_url = $this->url;

        $res = \Http::withHeaders($this->api_headers)->post($method_url, [
                'updateEnabled' => false,
                'listIds' => [$list_id ?? $this->getListId()],
                'email' => $email,
                'attributes' => $ATTRIBUTES,
            ]);

        return $res->body();
    }

    public function update($email, $ATTRIBUTES, $list_id = null)
    {
        $method_url = $this->url . urlencode($email);

        $res = \Http::withHeaders($this->api_headers)->put($method_url, [
                'listIds' => [$list_id ?? $this->getListId()],
                'attributes' => $ATTRIBUTES,
            ]);

        return $res->body();
    }

    public function delete($email, $list_id = null)
    {
        $method_url = $this->url . 'lists/' . ($list_id ?? $this->getListId()) . '/contacts/remove';

        $res = \Http::withHeaders($this->api_headers)->delete($method_url, [
            'emails' => [$email],
        ]);

        return $res->body();
    }

    public function getInfo($email)
    {
        $method_url = $this->url . urlencode($email);

        $res = \Http::withHeaders($this->api_headers)->get($method_url);

        return $res->body();
    }

}
