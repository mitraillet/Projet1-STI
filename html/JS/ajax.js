//Fonction testant si le JSON peut-être parsé
function testeJson(json) {
    let parsed;
    try {
        parsed = JSON.parse(json);
        /*parsed = 'C\'est bien du JSON dont les clés sont : <hr>'  //enlever dans la phase 2.1
         + Object.keys(parsed).join(' - ')
        +'<hr>'
        + json;*/
    }
    catch (e) {
        //parsed = json;  //phase01
        parsed = {"jsonError": {'error': e, 'json': json}};
    }
    return parsed;
};

function login() {
    let log = document.getElementById('login').value;
    let pass = document.getElementById('password').value;
    let type = 'login';
    $.post('INC/formSubmit.php',{login : log , password : pass, type : type }, manageReturn);
};

function getMessage(){
    $.post('INC/getMessages.php', manageReturn);
}

function manageReturn(retour) {
    let json = testeJson(retour);
    $(json[0]).html(json[1]);
};

function deconnexion(){
    $.post('INC/deco.php').done(window.location.reload());
};
