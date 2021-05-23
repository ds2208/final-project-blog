<form action="{{route('front.contact.send_message')}}" method="post" role="form" class="commenting-form">
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <input 
                name="name"
                type="text" 
                placeholder="{{__('Your Name')}}" 
                class="form-control"
                value='{{old('name')}}'
                >
            <div class="error-msg">
                @include('front._layout.partials.form_errors', ['fieldName' => 'name'])
            </div>
        </div>
        <div class="form-group col-md-6">
            <input 
                type="email" 
                placeholder="{{__('Email Address (will not be published)')}}" 
                class="form-control"
                name="email"
                value="{{old('email')}}"
                >
            <div class="error-msg">
                @include('front._layout.partials.form_errors', ['fieldName' => 'email'])
            </div>
        </div>
        <div class="form-group col-md-12">
            <textarea 
                placeholder="{{__('Type your message')}}" 
                class="form-control" 
                rows="20"
                name="message"
                >{{old('message')}}</textarea>
            <div class="error-msg">
                @include('front._layout.partials.form_errors', ['fieldName' => 'message'])
            </div>
        </div>
        <div class="form-group col-md-12">
            {!! htmlFormSnippet() !!}
            <div class="error-msg">
                @include('front._layout.partials.form_errors', ['fieldName' => 'name'])
            </div>
        </div>
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-secondary">{{__("Submit Your Message")}}</button>
        </div>
    </div>
</form>

@push('scripts')
<script src="{{url('/themes/front/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/front/js/additional-methods.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">
$('.commenting-form').validate({
    rules: {
        name: {
            required: true,
            rangelength: [2, 50]
        },
        email: {
            required: true,
            email: true,
            maxlength: 255
        },
        message: {
            required: true,
            rangelength: [50, 500]
        },
        recaptcha: {
            required: true
        }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});
</script>
@endpush
