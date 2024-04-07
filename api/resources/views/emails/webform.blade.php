@include('emails.components.header', ['settings' => $settings, 'title' => $form['name']])
                    <h1 style="color: 
                    @if ($settings['primary_color'])
                                            {{ $settings['primary_color'] }}
                                            @else
                                            #006AA7
                                    @endif    
                    ">
                      @if ($form['name'])
                      {{ $form['name'] }}
                      @endif
                    </h1>
                    <p>Hallo,<br>In dieser E-Mail erhältst Du alle Informationen des ausgefüllten Webformulars.</p>
                    @foreach ($formData as $key => $value)
                    <p style="font-weight: 600">{{ $key }}:</p>
                    <p>
                      {!! $value !!}

                    </p>
                    @endforeach
@include('emails.components.footer')