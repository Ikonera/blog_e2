function verificationMail(champ)
{
    var regex = (/^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/);
    if(!regex.test(champ.value))
    {
        surligne(champ, true);
        return false;
    }
    else
    {
        surligne(champ, false);
        return true;
    }
}

function verificationMDP(champ)
{
    if(champ.value.length < 3)
    {
        surligne(champ, true);
        return false;
    }
    else
    {
        surligne(champ, false);
        return true;
    }
}

function surligne(champ, erreur)
{
    if(erreur)
        champ.style.backgroundColor = "#ff0000";
    else
        champ.style.backgroundColor = "";
}

function verificationConfirmationMDP(champ)
{
    if(champ.value == document.getElementsByClassName(mdp))
    {
        surligne(champ, true);
        return false;
    }
    else
    {
        surligne(champ, false);
        return true;
    }
}

function verificationEnvoi(f)
{
    var mailOk = verificationMail(f.cr_mail);
    var passwordOk = verificationMDP(f.cr_password);
    var passwordVerificationOk = verificationConfirmationMDP(f.cr_password_verification);
   
    if(mailOk && passwordOk && passwordVerificationOk)
        return true;
    else
    {
        alert("Veuillez remplir correctement tous les champs");
        return false;
    }
}
h
