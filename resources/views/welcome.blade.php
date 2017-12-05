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

<label for="ville">
    <input id="city" name="ville" type="text" placeholder="Ville">
</label>
<label for="departement">
    <select id="department" name="departement">
        <option value="27">27</option>
        <option value="95">95</option>
        <option value="93">93</option>
        <option value="92">92</option>
        <option value="78">78</option>
    </select>
</label>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

<script>
    function accentMap() {
        return {
            "á": "a",
            "ö": "o",
            "ô": "o",
            "Ş": "S",
            "á": "a",
            "é": "e",
            "ë": "e",
            "É": "e",
            "è": "e",
            "ê": "e",
            "ÿ": "y",
            "'": " ",
            "-": " "
        }
    }

    function normalize(term) {
        var ret = "";
        for (var i = 0; i < term.length; i++) {
            ret += accentMap()[term.charAt(i)] || term.charAt(i);
        }
        return ret;
    }

    (function () {
        $.widget("custom.catcomplete", $.ui.autocomplete, {
            _create: function () {
                this._super();
                this.widget().menu("option", "items", "> :not(.ui-autocomplete-category)");
            },
            _renderMenu: function (ul, items) {
                var that = this;
                var currentCategory = "";

                $.each(items, function (index, item) {
                    var li;

                    if (item.category !== currentCategory) {
                        ul.append("<li class='ui-autocomplete-category'><b>" + item.category + "</b></li>");
                        currentCategory = item.category;
                    }
                    li = that._renderItemData(ul, item);
                    if (item.category) {
                        li.attr("aria-label", item.category + " : " + item.label);
                    }
                });
            }
        });

        var $cityInput = $('#city');
        var $deptInput = $('#department');

        $cityInput.catcomplete({
            minLength: 2,
            source: function (request, response) {
                $.get('api/city/' + request.term + '?formatted=true&department=' + $deptInput.val(), function (data) {
                    var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");

                    response($.grep(data, function(value) {
                        value = value.label || value.value || value;

                        return matcher.test(value) || matcher.test(normalize(value));
                    }));
                });
            }
        });
    })()
</script>
</body>
</html>
