<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Member;
use Illuminate\Http\Request;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Checkout;

class MemberController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $perPage = $request->get('per_page', 7); // Default 10 items per page
    $members = Member::paginate($perPage);

    return response()->json($members);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validasi request
        $validator = Validator::make($request->all(), [
            'nama_member' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'password' => 'required|same:konfirmasi_password'
        ]);

        if ($validator->fails()){
            return response()->json(
                $validator->errors(),
                422
            );
        };

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $member = Member::create($input);
        unset($input['konfirmasi_password']);

        return response()->json([
            'data' => $member
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return response()->json([
            'data' => $member
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
{
   
    // Hapus data kategori dari database
    $member->delete();

    return response()->json([
        'message' => 'success'
    ]);
}

public function banMember($memberId)
{
    $member = Member::find($memberId);
    if (!$member) {
        return response()->json(['message' => 'Member not found.'], 404);
    }

    $member->banned_until = Carbon::now()->addDays(7); 
    $member->save();

    return response()->json(['message' => 'Member has been banned successfully.']);
}
public function unbanMember($memberId)
{
    $member = Member::find($memberId);
    if (!$member) {
        return response()->json(['message' => 'Member not found.'], 404);
    }

    $member->banned_until = null; // Hapus tanggal banned
    $member->save();

    return response()->json(['message' => 'Member has been unbanned successfully.']);
}

public function search(Request $request)
{
    $perPage = $request->get('per_page', 7); // Default 10 items per page
    $search = $request->get('search'); // Parameter pencarian

    // Buat query awal
    $query = Member::query();

    // Tambahkan filter pencarian jika ada parameter pencarian
    if ($search) {
        $query->where('nama_member', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('no_hp', 'like', '%' . $search . '%');
    }

    // Paginate hasil
    $members = $query->paginate($perPage);
    
    if ($members->isEmpty()) {
        return response()->json([
            'message' => 'Member not found'
        ], 404);
    }
    return response()->json($members);
}


public function getMemberCheckout($memberId)
{
    $member = Member::find($memberId);
    if (!$member) {
        return response()->json(['message' => 'Member not found.'], 404);
    }

    $checkouts = $member->checkouts;

    return response()->json(['data' => $checkouts]);
}


}
