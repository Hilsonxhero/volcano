<?php

namespace Modules\Project\Http\Controllers\v1\App\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Common\Services\ApiService;


class ProjecIssueAttachmentController extends Controller
{
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($project, $id)
    {
        $media = projectIssueAttachmentRepo()->delete($id);
        ApiService::_success(trans('response.responses.200'));
    }
}
