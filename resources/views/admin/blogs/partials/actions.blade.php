<td class="text-center">
    <div class="btn-group">
        <a href="{{$blog->getFrontUrl()}}" class="btn btn-info" target="_blank">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{route('admin.blogs.edit', ['blog' => $blog->id])}}" class="btn btn-info">
            <i class="fas fa-edit"></i>
        </a>
        @if($blog->status == 1)
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#disable-modal"
            data-action="disable"
            data-id="{{$blog->id}}"
            data-name="{{$blog->title}}"
            >
            <i class="fas fa-minus-circle"></i>
        </button>
        @else
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#enable-modal"
            data-action="enable"
            data-id="{{$blog->id}}"
            data-name="{{$blog->title}}"
            >
            <i class="fas fa-check"></i>
        </button>
        @endif
        @if($blog->important == 1)
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#get-not-important-modal"
            data-action="get-not-important"
            data-id="{{$blog->id}}"
            data-name="{{$blog->title}}"
            >
            <i class="fas fa-lock"></i>
        </button>
        @else
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#get-important-modal"
            data-action="get-important"
            data-id="{{$blog->id}}"
            data-name="{{$blog->title}}"
            >
            <i class="fas fa-unlock"></i>
        </button>
        @endif
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#delete-modal"
            data-action="delete"
            data-id="{{$blog->id}}"
            data-name='{{$blog->title}}'
            >
            <i class="fas fa-trash"></i>
        </button>
    </div>
</td>