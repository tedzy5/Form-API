<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customers::where('deleted_at', null)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|alpha_dash|min:3|max:15',
            'last_name' => 'required|alpha_dash|min:2|max:20',
            'email' => 'required|email|unique:customers',
            'phone' => 'numeric|nullable|unique:customers',
            'category' => 'required|numeric',
        ], $messages = [
            'first_name.required' => 'Your first name is required.',
            'last_name.required' => 'Your last name is required.',
            'first_name.min' => 'Your full name is required.',
            'first_name.max' => 'Your full name is required.',
            'last_name.min' => 'Your real last name is required.',
            'last_name.max' => 'Your real last name is required.',
            'email.required' => 'Your full email is required.',
            'email.email' => 'Your full email is required',
            'email.unique' => 'Sorry, the email you just wrote is already taken.',
            'phone.numeric' => 'The phone number you entered has to be only numbers.',
            'phone.max' => 'Please provide us with a single phone number only.',
            'phone.unique' => 'Sorry, the phone number you provided is already taken.',
            'category.required' => 'Your category is required.'
        ]);

        //Customers::create($request->all());

//        return Customers::create([
//            'first_name' => request('first_name'),
//            'last_name' => request('last_name'),
//            'email' => request('email'),
//            'phone' => request('phone'),
//            'category' => request('category')
//        ]);

        //return redirect('/')->with('status', 'Form created for '. $request->first_name . ' ' . $request->last_name . ' successfully.')->with('messages', $messages);
        return redirect(url()->previous())->with('status', 'Data Your Comment has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Customers $customer)
    {
        $result = $customer->update([
            'first_name' => \request('first_name'),
            'last_name' => \request('last_name'),
            'phone' => \request('phone'),
            'email' => \request('email'),
            'category' => \request('category')
        ]);

        return response()->json([
            'status' => $result,
            'message' => 'Customer saved successfully.',
            'customer' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $result = Customers::findOrFail($id)->delete();

        return back();
    }
}
