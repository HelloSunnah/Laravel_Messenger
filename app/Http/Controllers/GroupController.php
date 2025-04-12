<?php
namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::get(); // Assuming you have a relationship defined for groups

        return response()->json($groups);
    }
    // Create a new group
    public function createGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'admin_id' => Auth::id(),
        ]);

        // Add the creator as an admin member
        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'is_admin' => true,
        ]);

        return response()->json(['message' => 'Group created successfully', 'group' => $group]);
    }

    // Add a member to the group
    public function addMember(Request $request, $groupId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $group = Group::findOrFail($groupId);

        // Check if the user is already a member
        if (GroupMember::where('group_id', $groupId)->where('user_id', $request->user_id)->exists()) {
            return response()->json(['message' => 'User is already a member'], 400);
        }

        GroupMember::create([
            'group_id' => $groupId,
            'user_id' => $request->user_id,
            'is_admin' => false,
        ]);

        return response()->json(['message' => 'User added to group']);
    }

    // Get group members
    public function getGroupMembers($groupId)
    {
        $members = GroupMember::where('group_id', $groupId)->with('user')->get();
        return response()->json(['members' => $members]);
    }

    // Leave group
    public function leaveGroup($groupId)
    {
        $userId = Auth::id();
        GroupMember::where('group_id', $groupId)->where('user_id', $userId)->delete();

        return response()->json(['message' => 'You have left the group']);
    }
}

