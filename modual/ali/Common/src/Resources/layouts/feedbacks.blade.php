@if(session()->has('feedbacks'))

    @foreach(session()->get('feedbacks') as $mess)

        $.toast({
        heading: "{{$mess["title"]}}",
        text: "{{$mess["body"]}}",
        showHideTransition: 'slide',
        icon: '{{$mess['type']}}'
        })
    @endforeach

@endif
