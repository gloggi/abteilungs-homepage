@include('emails.components.header', ['settings' => $settings, 'title' => $subject])
<h1 style="color: 
                    @if ($settings['primary_color'])
                                            {{ $settings['primary_color'] }}
                                            @else
                                            #006AA7
                                    @endif    
                    ">
                      @if ($subject)
                      {{ $subject }}
                      @endif
                    </h1>
<p> {!! $text !!}</p>
@include('emails.components.footer', ['hideAutoGeneration' => true])