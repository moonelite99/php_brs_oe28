<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Request as Contact;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::where('user_id', Auth::user()->id)->orderByDesc('created_at')->paginate(config('default.pagination'));

        return view('sent_requests', compact('contacts'));
    }

    public function solve($status)
    {
        $contacts = Contact::with('user', 'manager')->where('status', $status)->paginate(config('default.pagination'));

        return view('contacts.index', compact(['contacts', 'status']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactFormRequest $request)
    {
        Contact::create([
            'content' => $request->contact,
            'status' => config('default.req_unsolved'),
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('contacts.create')->with('status', trans('msg.create_success'));
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->update($request->all());
        } catch (ModelNotFoundException $e) {
            return redirect()->route('requests')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.update_successful'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('contacts.index')->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.delete_successful'));
    }
}
