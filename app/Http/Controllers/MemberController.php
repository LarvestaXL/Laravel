<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\ReturnTypePass;

class MemberController extends Controller
{

    public function __construct(){
         // Middleware untuk memperbolehkan mengakses Member kecuali index yang bisa diakses semua orang
        $this->middleware('auth:api')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $members = Member::all();

        return response()->json([
            'data' => $members
        ]);
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

}
