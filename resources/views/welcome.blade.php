<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <title>Laravel</title>
</head>
<body>

<input id="city" type="text" placeholder="Ville">
<button id="toggle">Show underlying select</button>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

<script>
    (function () {
        $.get('/api/city/Oise', function (data) {
            $('#city').autocomplete({
                minLength: 0,
                source: function (request, response) {
                    var cities = data.map(function (city) {
                        return { label: city.name + ', ' + city.cp, value: city.name }
                    });

                    response(cities);
                }
            }).autocomplete('search')
        });
    })()
</script>
</body>
</html>
