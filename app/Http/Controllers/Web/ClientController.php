<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Models\CustomerDetail;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.users.customer.customers');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $worker_user_id = $request->user_id;

        $user = null;
        if ($worker_user_id) {
            $user = User::findOrFail($worker_user_id);
        }

        return view('pages.users.customer.create-customer', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();



            $password = Str::random(8);

            $user_data = array_merge($request->only('first_name', 'last_name', 'middle_name', 'username', 'email'), ['password' => $password]);

            $user = User::updateOrCreate([
                'id' => $request->user_id ?? 0,
            ], $user_data);

            $user->addRole(User::ROLE['CUSTOMER']);

            $profile_data = $request->only('gender', 'birthdate', 'address', 'latitude', 'longitude', 'contact_number');

            UserProfile::updateOrCreate([
                'user_id' => $user->id,
            ], $profile_data);

            $customer_data = $request->only('facebook_url', 'occupation', 'company_name', 'company_website', 'industry', 'customer_type');

            CustomerDetail::create(array_merge($customer_data, ['user_id' => $user->id]));

            DB::commit();

            if ($request->acceptsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer Successfully Added',
                    'user' => $user,
                ]);
            }

            return redirect()->route('backend.customers.edit', $user->id)->withSuccess('Customer Successfully Added.');

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('backend-pages.users.customer.edit-customer', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();


            $user = User::findOr($id, function () {
                throw new Exception("User Not Found.", 404);
            });

            $user->update($request->only('first_name', 'last_name', 'middle_name', 'username', 'email'));

            $user->profile->update($request->only('gender', 'birthdate', 'address', 'latitude', 'longitude', 'contact_number'));

            $user->customer_details->update($request->only('facebook_url', 'occupation', 'company_name', 'company_website', 'industry', 'customer_type'));

            DB::commit();

            if ($request->acceptsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Customer Successfully Updated',
                    'user' => $user,
                ]);
            }

            return redirect()->route('backend.customers.edit', $user->id)->withSuccess('Customer Successfully Updated.');

        } catch (Exception $exception) {
            DB::rollBack();
            $exceptionHandler = new ExceptionHandlerService();
            return $exceptionHandler->handler($request, $exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
