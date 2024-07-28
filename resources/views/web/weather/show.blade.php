<!DOCTYPE html>
<html>
<head>
    <title>Dự báo thời tiết</title>
</head>
<body>
    <h1>Dự báo thời tiết cho {{ $location }}</h1>
    @if(isset($forecast['list']))
        <ul>
            @foreach($forecast['list'] as $weather)
                <li>
                    <strong>{{ \Carbon\Carbon::parse($weather['dt_txt'])->format('l, F j, Y g:i A') }}</strong><br>
                    Nhiệt độ: {{ $weather['main']['temp'] }}°C<br>
                    Thời tiết: {{ $weather['weather'][0]['description'] }}
                </li>
            @endforeach
        </ul>
    @else
        <p>Không có dữ liệu thời tiết.</p>
    @endif
</body>
</html>
