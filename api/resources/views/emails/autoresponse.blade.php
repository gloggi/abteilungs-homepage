@include('emails.components.header', ['settings' => $settings, 'title' =>$title])
<h1 style="color: 
                    @if ($settings['primary_color'])
                                            {{ $settings['primary_color'] }}
                                            @else
                                            #006AA7
                                    @endif    
                    ">
                      @if ($title)
                      {{ $title }}
                      @endif
                    </h1>
<p> {!! $autoresponseMessage !!}</p>
@include('emails.components.footer')