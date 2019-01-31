
function validColor($color)
{
    global $f3;
    return in_array($color, $f3->get('colors'));

}

function validString($color)
{
    if ($color != "" || !(ctype_alpha($color))){

        return false;

    }
    return true;
}