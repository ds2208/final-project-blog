<td>
    <button 
        style="align-self: stretch;"
        type="button" 
        class="btn btn-outline-warning" 
        data-toggle="modal" 
        data-target="#content-modal"
        data-action="content"
        data-name="{{$comment->name}}"
        data-email="{{$comment->email}}"
        data-content="{{$comment->content}}"
        >
        @lang("VIEW ALL")
    </button>
    {{\Str::limit($comment->content, 20, ' ...')}}
</td>