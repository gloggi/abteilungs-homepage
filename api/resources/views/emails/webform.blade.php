<!DOCTYPE html>
<html>
<head>
    <title>Web Form Email</title>
</head>
<body>
    <div>
        <div>
            <h1>Web Form Submission</h1>
        </div>

        <div>
            <p>Hello</p>
            <p>A new website form has been received. You can find all the data from the form below:</p>

            @foreach ($formData as $key => $value)
                <p><strong>{{ $key }}:</strong> {{ $value }}</p>
            @endforeach

            <p>Best regards,</p>
            <p>The Abteilungs Homepage</p>
        </div>
    </div>
</body>
</html>
