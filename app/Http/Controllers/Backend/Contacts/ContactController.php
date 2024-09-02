<?php

namespace App\Http\Controllers\Backend\Contacts;

use App\Http\Controllers\Backend\BackendController;
use App\Http\Requests\Backend\ContactsDataRequest;
use App\Models\Contact;
use App\Repository\ContactRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContactController extends BackendController
{
    public function __construct(
        private ContactRepositoryInterface $contactRepository,
    )
    {
        $this->middleware(['permission:edit contacts']);
    }

    public function edit(Request $request, Contact $contact): View
    {
        return $this->render('backend.contacts.create', compact('contact'));
    }

    public function update(ContactsDataRequest $request, Contact $contact): RedirectResponse
    {
        if ($this->contactRepository->update($contact->id, $request->validated())) {
            $message = ['type' => 'Success', 'message' => 'Contacts has been updated successfully'];
        }
        return redirect()->back()->with('message', $message ?? ['type' => 'Warning', 'message' => 'Something went wrong']);
    }

}
