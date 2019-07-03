function toggleAbstract(nr)
{
    console.log(nr);
    console.log(typeof nr);
    if(document.getElementById(nr).style.display == "block")
    {
        document.getElementById(nr).style.display = "none";
    }
    else
    {
        document.getElementById(nr).style.display = "block";
    }

}
