<?php

namespace App\Services;

use App\Services\Traits\ConsumeExternalService;

class CompanyService
{
    use ConsumeExternalService;

    protected $token;
    protected $url;

    public function __construct()
    {
        $this->token = config('services.micro_companies.token');
        $this->url = config('services.micro_companies.url');


    }

    public function getCompany(string $company)
    {
        return  $this->request('GET',"/company/{$company}");

    }
}
