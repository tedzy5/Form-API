<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $customers = Http::get(url('api/customers'));
        $deleted = Http::get(url('api/customers/deleted'));
        $categories = Http::get(url('api/categories'));
        if($customers->status() != 200 || $categories->status() != 200) {
            return 'No!';
        }

        $customers = json_decode($customers, true);
        $customers = collect($customers);

        $deleted = json_decode($deleted, true);
        $deleted = collect($deleted);

        $categories = json_decode($categories, true);
        $categories = collect($categories);
        //$customers = (object)$customers;

        return view('dashboard', compact('customers', 'categories', 'deleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $customer = new Customers();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->category = $request->category;
        $customer->save();

        return redirect()->route('form')->with('status', 'Form created for '. $request->first_name . ' ' . $request->last_name . ' successfully.');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Customers $customer)
    {
        $categories = Categories::all();
        $customer = Customers::find($customer->id);

        return view('welcome', compact('categories', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $customer = Customers::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|alpha_dash|min:3|max:15',
            'last_name' => 'required|alpha_dash|min:2|max:20',
            'email' => ['required', 'email', Rule::unique('customers')->ignore($customer->id)],
            'phone' => ['numeric', 'nullable', Rule::unique('customers')->ignore($customer->id)],
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

        Customers::where('id', $request->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'category' => $request->category
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
