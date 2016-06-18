function displayIndex() {
    document.getElementById("homepage").style.display = "block";
}

function displaySignUp() {
    document.getElementById("signup-div").style.display = "block";
}

function closeSignUp() {
    document.getElementById("signup-div").style.display = "none";
}
function closeLogin(){
    document.getElementById("login-div").style.display = "none";
}
function updateParentInfoAndDisplay(){
    document.getElementById("formInfo").innerHTML = "Use the group name as your account name";
    document.getElementById("login-div").style.display = "block";
}
function updateKidInfoAndDisplay(){
    document.getElementById("formInfo").innerHTML = "Use the group name your parents set up plus your name, EX: TheStarks.Jimmy";
    document.getElementById("login-div").style.display = "block";
}

/**
 * 
 * Validates all text areas for proper login
 *
 **/
function validateSignUp() {
    /**
     * Values of form fields
     **/
    var email = document.forms["signupform"]["email"].value;
    var firstN = document.forms["signupform"]["firstName"].value;
    var lastN = document.forms["signupform"]["lastName"].value;
    var groupN = document.forms["signupform"]["groupName"].value;
    var pwd1 = document.forms["signupform"]["password1"].value;
    var pwd2 = document.forms["signupform"]["password2"].value;

    /**
     * Sets style guide for response field
    **/
    var response = document.getElementById("response_signup");
    response.style.textAlign = "center";
    response.style.color = "red";
    /**
    * Checks elements for basic valid inputs
    **/
    if (email == null || email == "") {
        response.innerHTML = "Must have valid email";
        return false;
    }
    if (firstN == null || firstN == "") {
        response.innerHTML = "You must enter your first name";
        return false;
    }
    if (lastN == null || lastN == "") {
        response.innerHTML = "You must enter your last name";
        return false;
    }
    if (groupN == null || groupN == "") {
        response.innerHTML = "You must have a last name";
        return false;
    }
    if (pwd1 == null || pwd1 == "") {
        response.innerHTML = "You must enter a password";
        return false;
    }
    if (pwd2 == null || pwd2 == "") {
        response.innerHTML = "You must re-enter your password";
        return false;
    }
    if (pwd1 != pwd2) {
        response.innerHTML = "Passwords do not match";
        return false;
    }
}
/**
 * 
 * Verifies proper entry into all text fields for Login form
 * 
 **/
function validateLogin() {
    /**
     * Values of form fields
     **/
    var accName = document.forms["loginform"]["accName"].value;
    var pwd = document.forms["loginform"]["password"].value;

    /**
     * Sets style guide for response field
     **/
    var response = document.getElementById("response_login");
    response.style.textAlign = "center";
    response.style.color = "red";

    if (accName == null || accName == "") {
        response.innerHTML = "No account name was entered";
        return false;
    }
    if (pwd == null || pwd == "") {
        response.innerHTML = "No password was entered";
        return false;
    }

}