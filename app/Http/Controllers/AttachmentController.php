<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function show(Group $group, Post $post, Attachment $attachment)
    {
        $groupId = $group->id;
        $postId = $post->id;
        $attachmentId = $attachment->id;
        if (!$attachment) {
            abort(404, 'File non trovato.');
        }

        return response()->file(storage_path('app/public/' . $attachment->file_path));
    }

}
