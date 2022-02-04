<?php

namespace App\Http\Controllers\Api\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        try {
            $companies = CompanyResource::collection(Company::paginate())->response()->getData();

            return response([
                'status' => 'success',
                'data'   => $companies,
            ], 200);
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function store(CompanyRequest $request)
    {
        try {

            $company = Company::create([
                'name'           => request('name'),
                'email'          => request('email'),
                'phone'          => request('phone'),
                'no_of_counters' => request('no_of_counters'),
                'sub_start_date' => request('sub_start_date'),
                'sub_end_date'   => request('sub_end_date'),
            ]);
            // if ($company) {
            //     $data = [
            //         "company_id" => $company->id,
            //         'name'       => request('admin_name'),
            //         'email'      => request('admin_email'),
            //         'phone'      => request('admin_phone'),
            //         'password'   => Hash::make(request('admin_initial_pass')),
            //     ];

            //     User::create($data);

            // }

            return response([
                'status'     => 'success',
                'statusCode' => 201,
                'message'    => 'Successfully added company...',
                'data'       => CompanyResource::make($company),
            ]);

        } catch (Exception $e) {
            return serverError($e);
        }
    }
    public function update($id)
    {
        try {
            $company = Company::where('_id', $id)->first();

            if ($company) {
                $company->name           = request('name') ?? $company->name;
                $company->email          = request('email') ?? $company->email;
                $company->phone          = request('phone') ?? $company->phone;
                $company->no_of_counters = request('no_of_counters') ?? $company->no_of_counters;
                $company->sub_start_date = request('sub_start_date') ?? $company->sub_start_date;
                $company->sub_end_date   = request('sub_end_date') ?? $company->sub_end_date;

                $company->update();
                return response([
                    'status'     => 'success',
                    'statusCode' => 202,
                    'message'    => 'Successfully update company...',
                    'data'       => CompanyResource::make($company),
                ]);
            } else {
                return itemNotFound();
            }
        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function show($id)
    {
        try {
            $company = Company::where('_id', $id)->first();
            if ($company) {
                return response([
                    'status' => 'success',
                    'data'   => CompanyResource::make($company),
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $company = Company::where('_id', $id)->first();

            if ($company) {
                $company->delete();
                return response([
                    'status'  => 'success',
                    'message' => 'Company deleted successfully',
                ], 200);
            } else {
                return itemNotFound();
            }

        } catch (Exception $e) {
            return serverError($e);
        }

    }

    public function search()
    {
        // dd(request()->all());
        try {
            $data      = request('keyword');
            $companies = null;

            if ($data) {
                $companies = Company::where('name', 'like', "%{$data}%")
                    ->orWhere('email', 'like', "%{$data}%")
                    ->orWhere('phone', 'like', "%{$data}%")
                    ->orWhere('no_of_counters', 'like', "%{$data}%")
                    ->orWhere('sub_start_date', 'like', "%{$data}%")
                    ->orWhere('sub_end_date', 'like', "%{$data}%")
                    ->paginate();
            } else {
                $companies = Company::paginate();
            }

            return response([
                'status' => 'success',
                'data'   => CompanyResource::collection($companies)->response()->getData(),
            ], 200);

        } catch (Exception $e) {
            return serverError($e);
        }
    }
}