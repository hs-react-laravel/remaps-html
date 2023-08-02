@php
    $snippetRoute = route('api.snippet.show', ['id' => $uid]);
    $resizerRoute = asset('customjs/iframeResizer.min.js');
    echo "document.write('<iframe src=\"".$snippetRoute."\" style=\"border:0px;transition:height 0.5s;\" width=\"100%\" height=\"320\" allowtransparency=\"true\" id=\"snippet_widget\" referrerpolicy=\"origin\"></iframe><script src=\"".$resizerRoute."\"></script><script type=\"text/javascript\">iFrameResize(false,\"#snippet_widget\");</script>')";
@endphp
