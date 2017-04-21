<html>
<head>
<title>MyMenu</title>
 
<!--The CSS code.-->
<style type="text/css" media="screen">

#mymenu
{    margin: 0;
    padding: 0;
}

#mymenu li
{    margin: 0;
    padding: 0;
    list-style: none;
    float: left;
}

#mymenu li a
{    display: block;
    margin: 0 1px 0 0;
    padding: 4px 10px;
    width: 80px;
    background: #bbbaaa;
    color: #ffffff;
    text-align: center;
}

#mymenu li a:hover
{    background: #aaddaa}

#mymenu ul
{    position: absolute;
    visibility: hidden;
    margin: 0;
    padding: 0;
    background: #eeebdd;
    border: 1px solid #ffffff}

    #mymenu ul a
    {    position: relative;
        display: block;
        margin: 0;
        padding: 5px 10px;
        width: 80px;
        text-align: left;
        background: #eeebdd;
        color: #000000;
}

    #mymenu ul a:hover
    {    background: #aaffaa;
}
</style>
<!--The end of the CSS code.-->

<!--The Javascript menu code.-->
<script type="text/javascript">
//variables' declaration
var timer        = 0;
var item      = 0;

//function for opening of submenu elements
function openelement(num)
{    
    
//checks whether there is an open submenu and makes it invisible 
if(item) item.style.visibility = 'hidden';

    //shows the chosen submenu element
    item = document.getElementById(num);
    item.style.visibility = 'visible';
}

// function for closing of submenu elements
function closeelement()
{
//closes the open submenu elements and loads the timer with 500ms
timer = window.setTimeout('if(item) item.style.visibility = 'hidden';',500);
}

//function for keeping the submenu loaded after the end of the 500 ms timer
function keepsubmenu()
{
        window.clearTimeout(timer);
}
//hides the visualized menu after clicking outside of its area and expiring of the loaded timer
document.onclick = closeelement; 

</script>
<!--END of CSS code-->

</head>
<body>

<!--HTML code for the menu -->
<ul id="mymenu">
    <li><a href="http://siteground.com/">Home</a>
    </li>
    <li><a href="#" onmouseover="openelement('menu2')">Tutorials</a>
        <ul id="menu2" onmouseover="keepsubmenu()" onmouseout="closeelement()">
        <a href="#">CSS</a>
        <a href="#">Flash</a>
        </ul>
    </li>
    <li><a href="#" onmouseover="openelement('menu3')" onmouseout="closeelement()">More</a>
        <ul id="menu3" onmouseover="keepsubmenu()" onmouseout="closeelement()">
        <a href="#">About Us</a>
        <a href="#">Contact Us</a>
        </ul>
    </li>
</ul>
<div style="clear:both"></div>
<!--the end of the HTML code for the menu -->
</body>
</html>