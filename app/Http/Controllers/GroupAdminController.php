<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupAdminController extends Controller
{
    // Assign admin role to a member
    public function makeAdmin($groupId, $userId)
    {
        $group = Group::findOrFail($groupId);

        if ($group->admin_id !== Auth::id()) {
            return response()->json(['message' => 'Only the group admin can assign admins'], 403);
        }

        GroupMember::where('group_id', $groupId)->where('user_id', $userId)->update(['is_admin' => true]);

        return response()->json(['message' => 'User is now an admin']);
    }

    // Remove a member from the group
    public function removeMember($groupId, $userId)
    {
        $group = Group::findOrFail($groupId);

        if ($group->admin_id !== Auth::id()) {
            return response()->json(['message' => 'Only the group admin can remove members'], 403);
        }

        GroupMember::where('group_id', $groupId)->where('user_id', $userId)->delete();

        return response()->json(['message' => 'User removed from group']);
    }

    // Delete group (Only admin can delete)
    public function deleteGroup($groupId)
    {
        $group = Group::findOrFail($groupId);

        if ($group->admin_id !== Auth::id()) {
            return response()->json(['message' => 'Only the group admin can delete this group'], 403);
        }

        $group->delete();

        return response()->json(['message' => 'Group deleted successfully']);
    }
}

