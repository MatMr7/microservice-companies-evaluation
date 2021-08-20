<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluation;
use App\Http\Resources\EvaluationResource;
use App\Models\Evaluation;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    protected $repository;
    protected $companyService;

    public function __construct(Evaluation $evaluation, CompanyService $companyService)
    {
        $this->repository = $evaluation;
        $this->companyService = $companyService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($company_uuid)
    {
        $evaluations = $this->repository->where('company_uuid',$company_uuid)->get();
        return EvaluationResource::collection($evaluations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvaluation $request, $company_uuid)
    {
        $response = $this->companyService->getCompany($company_uuid);
        $status = $response->status();
        if($status != 200)
            return response()->json([
                'message' => "Company $company_uuid not found"
            ],$status);

        $evaluation = $this->repository->create($request->validated());
        return new EvaluationResource($evaluation);
    }

}
