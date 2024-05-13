<?php
namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Hymn;
use App\Models\MediaFileUpvote;
use App\Models\UserHinario;
use App\Models\UserHymnHinario;
use App\Services\GlobalFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function submitFeedback(Request $request)
    {
        $feedback = new Feedback();
        $feedback->entity_type = $request->get('entityType');
        $feedback->entity_id = $request->get('entityId');
        $feedback->user_id = Auth::user()->getAuthIdentifier();
        $feedback->message = $request->get('message');
        $feedback->save();

        return '<span><i class="fas fa-thumbs-up"></i> ' . __('universal.feedback_form.response') . ' </span>';
    }

    public function submitUpVote(Request $request)
    {
        $mediaFileUpVote = MediaFileUpvote::where('media_file_id', $request->get('media_file_id'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->first();

        if (empty($mediaFileUpVote)) {
            $mediaFileUpVote = new MediaFileUpvote();
            $mediaFileUpVote->user_id = Auth::user()->getAuthIdentifier();
            $mediaFileUpVote->media_file_id = $request->get('media_file_id');
            $mediaFileUpVote->save();
        }

        return '
            <a class="downvote_"' . $request->get('media_file_id') . '">
                    <i class="fas fa-thumbs-up"></i>
            </a>
            ';
    }

    public function submitDownVote(Request $request)
    {
        $mediaFileUpVote = MediaFileUpvote::where('media_file_id', $request->get('media_file_id'))
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->first();

        if (!empty($mediaFileUpVote)) {
            $mediaFileUpVote->delete();
        }

        return '
        <a class="upvote_"' . $request->get('media_file_id') . '">
                    <i class="far fa-thumbs-up"></i>
                </a>
                ';
    }

    public function addHymnToUserHinario(Request $request)
    {
        if (empty($request->get('hymn_id'))) {
            // ERROR
        }

        $hymn = Hymn::where('id', $request->get('hymn_id'))->first();

        if ($request->get('action') == 'create') {
            if ($request->get('new_hinario_name') == '') {
                return '<a class="hymn_added_' . $hymn->id . '">
                    <i class="fas fa-exclamation-circle"></i> ' . __('universal.add_hymn_form.enter_name') .'
                </a>';
            }
            $userHinario = new UserHinario();
            $userHinario->user_id = Auth::user()->getAuthIdentifier();
            $userHinario->name = $request->get('new_hinario_name');
            $userHinario->code = GlobalFunctions::generateUserHinarioCode();
            $userHinario->save();

        } else {
            $userHinario = UserHinario::where('id', $request->get('user_hinario_id'))
                ->where('user_id', Auth::user()->getAuthIdentifier())
                ->first();
            if (empty($userHinario)) {
                return '<a class="hymn_added_' . $hymn->id . '">
                    <i class="fas fa-frown"></i> ' . __('universal.add_hymn_form.hinario_missing') .'
                </a>';
            }
        }

        $userHymnHinario = UserHymnHinario::where('hinario_id', $userHinario->id)->orderBy('list_order', 'DESC')->first();
        if (empty($userHymnHinario)) {
            $listOrder = 1;
        } else {
            $listOrder = $userHymnHinario->list_order + 1;
        }

        $newUserHymnHinario = new UserHymnHinario();
        $newUserHymnHinario->hinario_id = $userHinario->id;
        $newUserHymnHinario->hymn_id = $hymn->id;
        $newUserHymnHinario->list_order = $listOrder;
        $newUserHymnHinario->original_hinario = $hymn->received_hinario;
        $newUserHymnHinario->save();

        return '<a class="hymn_added_' . $hymn->id . '" style="color: #337ab7;">
                    <i class="far fa-thumbs-up"></i> ' . __('universal.add_hymn_form.added') .'
                </a>';
    }
}
