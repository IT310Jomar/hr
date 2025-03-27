{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SendGrid Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h2>New Email</h2>
    <p><strong>Email: </strong>{{ $data['selectedOptions'] }}</p>
    <p><strong>Subject: </strong>{{ $data['subject'] }}</p>
    <p><strong>Message: </strong>@if (strpos($data['message'], 'data:image') !== false) 
    @else
       {{ $data['message'] }}
    @endif</p>
    
</body>
</html> --}}
{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SendGrid Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
</head>
<body>
    <h2>New Email</h2>
    <p><strong>Email: </strong>{{ $data['selectedOptions'] }}</p>
    <p><strong>Subject: </strong>{{ $data['subject'] }}</p>
    <p><strong>Message: </strong>
        @if (strpos($data['message'], 'data:image') !== false) 
            <!-- Handle image content -->
        @else
         
            {{ $data['message'] }}
        @endif
    </p>
</body>
</html> --}}
{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SendGrid Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
</head>
<body>
    <h2>Sirius</h2>
    <p><strong>Email: </strong>{{ $data['selectedOptions']}}</p>
    <p><strong>Subject: </strong>{{ $data['subject'] }}</p>
    <p><strong>Message: </strong>
        @if (strpos($data['message'], 'data:image') !== false) 
            <!-- Handle image content -->
            
        @else
           
           {{  $data['message'] }}
        @endif
    </p>
</body>
</html> --}}
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SendGrid Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">


</head>

<body>
    <h2>Sirius</h2>
    <p><strong>Email: </strong>{{ $data['selectedOptions'] }}</p>
    <p><strong>Subject: </strong>{{ $data['subject'] }}</p>
    <p><strong>Message: </strong>
        @if (is_array($data['message']))
            @foreach ($data['message'] as $msg)
                @if (strpos($msg, 'data:image') === false)
                    <p>{{ $msg }}</p>
                @else
                    <img src="cid:hello/image">
                @endif
            @endforeach
        @else
            <p>{{ $data['message'] }}</p>
        @endif

    </p>
</body>

</html>

