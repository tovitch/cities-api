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

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

<script>
    (function () {

        $.widget( "custom.catcomplete", $.ui.autocomplete, {
            _create: function() {
                this._super();
                this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
            },
            _renderMenu: function( ul, items ) {
                var that = this,
                    currentCategory = "";
                $.each( items, function( index, item ) {
                    var li;
                    if ( item.category != currentCategory ) {
                        ul.append( "<li class='ui-autocomplete-category'><b>" + item.category + "</b></li>" );
                        currentCategory = item.category;
                    }
                    li = that._renderItemData( ul, item );
                    if ( item.category ) {
                        li.attr( "aria-label", item.category + " : " + item.label );
                    }
                });
            }
        });

        var $cityInput = $('#city');

        $cityInput.catcomplete({
            minLength: 2,
            source: []
        });

        var timeout = null;

        $cityInput.on('keyup', function () {
            var $this = $(this);
            if (timeout) {
                clearTimeout(timeout);
            }

            timeout = setTimeout(function () {
                $.get('/api/city/' + $this.val() + '?formatted=true', function (data) {
                    $('#city').catcomplete('option', 'source', data).catcomplete('search')
                });
            }, 200);
        });
    })()
</script>
</body>
</html>
