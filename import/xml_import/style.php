<?php

function output_style_header()
{

	echo <<< __EOF__
<style type="text/css">
body {margin-top:10px; margin-right:0px; margin-bottom:0px; margin-left:10px; width:750px; }
p {font-family: century, serif; font-size: 14px;}
.warning {background-color: yellow;}
.error {background-color: red;}
.left {text-align: left;}
.right {text-align: right;}
.error_button {
    border: 1px solid #000;
    background-color: red;
}
.warn_button {
    border: 1px solid #000;
    background-color: yellow;
}
.good_button {
    border: 1px solid #000;
    background-color: palegreen;
}
.blank_button {
    border: 1px solid #000;
    background-color: white;
    color: white;
}

table, th, td
{
border: 1px solid black;
}
pre {font-family: courier; font-size: 14px;}
</style>
__EOF__;

} // output_style_header

?>
