<?php

namespace App\Http\Controllers\Contact;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Retrieve a paginated list of contacts based on the search query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function retrieve(Request $request): JsonResponse
    {
        $contacts = Contact::where('user_id', Auth::id());

        $search = $request->search;
        if ($search) {
            $contacts = $contacts->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('company', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $contacts = $contacts->paginate($request->limit);

        return response()->json([
            'contacts' => $contacts->items(),
            'total' => $contacts->total(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('contact.list')
            ->with('title', "Contacts");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('contact.form')
            ->with('title', "Add Contact")
            ->with('route', route('contact.store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validate user input
        $request->validate([
            'name'      => 'required|string|max:255',
            'company'   => 'string|max:255',
            'phone'     => 'string|max:255',
            'email'     => 'email|max:255',
        ]);

        // Create a new contact record
        Contact::create([
            'user_id'   => Auth::id(),
            'name'      => $request->name,
            'company'   => $request->company,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        // Redirect user after storing
        return response()->json([
            'route' => route('contact.index')
        ], 200);
    }

    /**
     * Show the form for editing the specified contact.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function edit($id)
    {
        $contact = Contact::where([
            ['id', $id],
            ['user_id', Auth::id()]
        ])->firstOrFail();

        return view('contact.form')
            ->with('title', "Edit Contact")
            ->with('route', route('contact.update', $id))
            ->with('data', $contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // Validate user input
        $request->validate([
            'name'      => 'required|string|max:255',
            'company'   => 'string|max:255',
            'phone'     => 'string|max:255',
            'email'     => 'email|max:255',
        ]);

        // Retrieve the contact by ID
        $contact = Contact::where([
            ['id', $id],
            ['user_id', Auth::id()]
        ])->firstOrFail();

        // Update the contact record
        $contact->update([
            'name'      => $request->name,
            'company'   => $request->company,
            'phone'     => $request->phone,
            'email'     => $request->email,
        ]);

        // Redirect user after updating
        return response()->json([
            'route' => route('contact.index')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return response()->json("Contact Deleted", 200);
    }
}
