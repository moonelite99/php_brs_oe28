<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Request as Contact;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contact\ContactRepositoryInterface;

class ContactController extends Controller
{
    protected $contactRepo;

    public function __construct(ContactRepositoryInterface $contactRepositoryInterface)
    {
        $this->contactRepo = $contactRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = $this->contactRepo->findByUser(Auth::user()->id);

        return view('sent_requests', compact('contacts'));
    }

    public function solve($status)
    {
        $contacts = $this->contactRepo->findByStatus($status);

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
        $this->contactRepo->createContact($request->contact, $request->user_id);

        return redirect()->route('contacts.create')->with('status', trans('msg.create_success'));
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
            $this->contactRepo->update($request->all(), $id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
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
            $this->contactRepo->delete($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('fail_status', trans('msg.find_fail'));
        }

        return redirect()->back()->with('status', trans('msg.delete_successful'));
    }
}
