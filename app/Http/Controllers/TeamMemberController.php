<?php

namespace App\Http\Controllers;

use View;
use App\TeamMember;
use App\Team;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth:admin');
		$this->middleware('has_role:team_members');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teamMembers = TeamMember::take(20)->latest()->get();

        return view('admin.team_members.index', [
            'team_members' => $teamMembers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Team::all();

        return view('admin.team_members.form', [
            'teams' => $teams,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('image_file')) {
            $path = $request->file('image_file')->store('public/uploads');
            $request->merge(['image_path' => $path]);
        }

        TeamMember::create($request->all());

        return redirect()->route('team-members.index')->with('status', 'Team member created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeamMember  $teamMember
     * @return \Illuminate\Http\Response
     */
    public function show(TeamMember $teamMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeamMember  $teamMember
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamMember $teamMember)
    {
        $teams = Team::all();

        return view('admin.team_members.form', [
            'team_member' => $teamMember,
            'teams' => $teams,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeamMember  $teamMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        if ($request->has('image_file')) {
            $path = $request->file('image_file')->store('public/uploads');
            $request->merge(['image_path' => $path]);
        }

        $teamMember->update($request->all());

        return redirect()->route('team-members.index')->with('status', 'Team member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeamMember  $teamMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();

		return redirect()
            ->route('team-members.index')
            ->with('status', 'Team member deleted successfully');
    }

    public function search(Request $request)
    {
        $teamMembers = TeamMember::where('name', 'like', '%'.$request->input('query').'%')
            ->take(20)
            ->latest()
            ->get();

        $html = View::make('admin.team_members.table', [
            'team_members' => $teamMembers
        ]);

        $response = $html->render();

        return response()->json([
            'status' => 'success',
            'html' => $response
        ]); 
    }
}
