<td class="text-center">
    <div class="btn-group">
        <a href="{{$comment->blog->getFrontUrl()}}" target="_blank" class="text-cyan">
            {{\Str::limit($comment->blog->title, 20, ' ...')}}
        </a>
    </div>
</td>