<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // direct contact page
    public function list() {
        $contacts = Contact::when(request('key'),function($query){
            $key = request('key');
            $query->where('subject','like','%'. $key . '%');
        })
        ->orderBy('id', 'desc')
        ->paginate(10);
        $contacts->appends(request()->all());
        return view('admin.contact.contact',compact('contacts'));
    }

    // download contact list csv
    public function generateCsV() {
        $data = Contact::get();
        $fileName = 'contactList.csv';
        $fp = fopen($fileName, 'w+');
        fputcsv($fp, array('Name', 'Email', 'Subject', 'Message'));

        foreach($data as $row){
            fputcsv($fp, array($row->name, $row->email, $row->subject, $row->message));
        }

        fclose($fp);
        $headers = array('Content-Type' => 'text/csv');

        return response()->download($fileName, 'contactList.csv', $headers);
    }

    // create contact
    public function contactCreate(Request $request) {
        $this->checkContactInfo($request);
        $data = $this->getContactData($request);
        Contact::create($data);
        return redirect()->route('user#contactPage')->with(['createSuccess'=>'Your Message Sent Successfully...']);
    }

    // delete contact
    public function delete($id){
        Contact::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Selected Message is Deleted...']);
    }

    // check contact info
    private function checkContactInfo($request){
        Validator::make($request->all(),[
            'userName' => 'required',
            'userEmail' => 'required',
            'messageSubject' => 'required',
            'messageInfo' => 'required',
        ],[])->validate();
    }

    // get contact data
    private function getContactData($request){
        return([
            'name' => $request->userName,
            'email' => $request->userEmail,
            'subject' => $request->messageSubject,
            'message' => $request->messageInfo,
        ]);
    }
}
