<?php
    $json = file_get_contents("content.json");
    $content = json_decode($json, true);


    function render_link_row($links)
    {
        for ($i = 0; $i < count($links) - 1; $i++) {
            foreach ($links[$i] as $name => $url) {
                echo "<td><a href=\"$url\">$name</a></td>";
            }
        }
        foreach (end($links) as $name => $url) {
            echo "<td class=\"last\"><a href=\"$url\">$name</a></td>";
        }
    }

    function render_ad_row($links)
    {
        for ($i = 0; $i < count($links) - 1; $i++) {
            foreach ($links[$i] as $name => $url) {
                echo "<td><a rel=\"nofollow\" href=\"$url\">$name</a></td>";
            }
        }
        foreach (end($links) as $name => $url) {
            echo "<td class=\"last\"><a rel=\"nofollow\" href=\"$url\">$name</a></td>";
        }
    }
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie6"> <![endif]-->
<!--[if IE 7 ]>
<html class="ie7"> <![endif]-->
<!--[if IE 8 ]>
<html class="ie8"> <![endif]-->
<!--[if IE 9 ]>
<html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>qDuke.com</title>
    <link rel="stylesheet" type="text/css" href="styles.css"/>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-5900287-15']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
</head>

<body>
<div id="shell">
<div id="header">
    <div id="logo">
        <a href="http://qduke.com"></a>
    </div>
</div>

<table id="search-table">
        <tbody>
        <tr class="search_options">
            <td id="search_bar" colspan="3" align="center">
                <input id="search" name="query"
                       type="text" style="background:transparent"
                       value=""
                       onkeydown="if (event.keyCode == 13) search(event)"/>
            </td>
            <td>
                <div id="google_search"><input onclick="search(event)" type="submit" name="google" value=""/></div>
            </td>
            <td>
                <div id="duke_search"><input onclick= "search(event)" type="submit" name="duke" value=""/></div>
            </td>
        </tr>
        </tbody>
</table>
<table id="selection_menu">
    <tr class="primary_options">
      <?php
         render_link_row($content['links'][0]);
      ?>
    </tr>
    <?php
       for ($i = 1; $i < count($content['links']); $i++) {
           echo '<tr class="secondary_options">';
           render_link_row($content['links'][$i]);
           echo '</tr>';
       }
    ?>
    <tr class="ad-label">
        <td colspan=5 style="background: none; text-align: left; padding-left: 5px; font-size: 14px; color: #333;"><p>
            Ads</p>
    </tr>
    <?php
       foreach ($content['ads'] as $row) {
           echo '<tr class="advertising secondary_options ads">';
           render_ad_row($row);
           echo '</tr>';
       }
    ?>
</table>

<br/>
<br/>

<div id="footer">
    <p>&copy; 2012 <a href="http://dukechronicle.com">The Chronicle</a> | <a
            href="http://dukechronicle.com/advertising">Advertising</a>
        | <a href="http://dukechronicle.com/contact">Contact</a> |
        <a style="color: #001950"
           href="http://spreadsheets.google.com/viewform?formkey=dHlnWnZQTTZyTmQxUXR5RFNaMm9ldWc6MA">Feedback</a>
    </p>
</div>
</div>
<script type="text/javascript">
    document.getElementById('search').focus();

    // Cross-browser implementation of element.addEventListener()
    function addListener(element, type, expression, bubbling) {
        bubbling = bubbling || false;

        if (window.addEventListener) { // Standard
            element.addEventListener(type, expression, bubbling);
            return true;
        } else if (window.attachEvent) { // IE
            element.attachEvent('on' + type, expression);
            return true;
        } else return false;
    }

    function click(e) {
        if (e.preventDefault) e.preventDefault();
        else e.returnValue = false

        if (e.stopPropagation) e.stopPropagation();
        else window.event.cancelBubble = true;
        var t = (window.event) ? e.srcElement : e.target;
        if (t.nodeName == 'A') {
            if (t.href.indexOf(location.host) == -1) {
                var url = t.href.match(/:\/\/(.[^/]+)/)[1].replace(/(www.)/g, "").replace(/[^a-z|A-Z|./]/g, "");
                _gat._getTrackerByName()._trackEvent("Outbound Links", url);
                setTimeout('document.location = "' + t.href + '"', 100);
            }
        }
    }

    function search(e) {
        if (e.preventDefault) e.preventDefault();
        else e.returnValue = false

        if (e.stopPropagation) e.stopPropagation();
        else window.event.cancelBubble = true;

        var target = e.target.name || "google";

        var redirect;
        var query = document.getElementById('search').value;
        if (target == "duke") {
            redirect = 'http://duke.edu/search/?q=' + query;
        } else {
            redirect = 'http://google.com/search?q=' + query;
        }
        _gat._getTrackerByName()._trackEvent("Search", query);
        setTimeout('document.location = "' + redirect + '"', 100);
    }

    addListener(document, 'click', click);
</script>
</body>
</html>


