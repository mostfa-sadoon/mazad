$(document).ready(function() {
    const firebaseConfig = {
        apiKey: "AIzaSyA14fIRJiJTGACLYvDgHl4Gf4YJaF7Cg9w",
        authDomain: "maza-74bb3.firebaseapp.com",
        projectId: "maza-74bb3",
        storageBucket: "maza-74bb3.appspot.com",
        messagingSenderId: "373443321646",
        appId: "1:373443321646:web:32b28629bab00bdc15e4bf",
        measurementId: "G-46CG11HDL6"
      };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'invisible',
        'callback': function (response) {
            // reCAPTCHA solved, allow signInWithPhoneNumber.
            console.log('recaptcha resolved');
        }
    });
    onSignInSubmit();
    });



         function onSignInSubmit() {
            $('#verifPhNum').on('click', function() {

            // { verificationId : localStorage.getItem("confirmationResult") }
            // window.confirmationResult['verificationId'] = localStorage.getItem("confirmationResult");

            let phoneNo = '';
            var code = $('#codeToVerify').val();
            console.log(code);
            // $(this).attr('disabled', 'disabled');
            $(this).text('Processing..');

            // return firebase.auth.PhoneAuthProvider.credential(window.confirmationResult,
            // code);

            console.log(window.confirmationResult);
            // console.log(window.confirmationResult.verificationId);


            window.confirmationResult.confirm(code).then(function (result) {
                        alert('Succecss');
                var user = result.user;
                console.log(user);

                setTimeout(() => {
                    $(this).text('Verify Phone No');
                }, 2000);
                // ...
            }.bind($(this))).catch(function (error) {
                alert('Failed');
                // User couldn't sign in (bad verification code?)
                // ...
                // $(this).removeAttr('disabled');
                $(this).text('Invalid Code');
                setTimeout(() => {
                    $(this).text('Verify Phone No');
                }, 2000);
            }.bind($(this)));


        });


    $('#getcode').on('click', function () {

        alert('Getting Your Code...');
        // var phoneNo = $('#number').val();
        var phoneNo = '+201091032662';
        console.log(phoneNo);
        // getCode(phoneNo);
        var appVerifier = window.recaptchaVerifier;
        firebase.auth().signInWithPhoneNumber(phoneNo, appVerifier)
        .then(function (confirmationResult) {

            window.confirmationResult=confirmationResult;
            localStorage.setItem("confirmationResult" , confirmationResult['verificationId']);
            coderesult=confirmationResult;
            console.log(coderesult);
            // console.log(coderesult['verificationId']);
            // Add Client ___________________________________________________________________________________________________________

        }).catch(function (error) {
            console.log(error.message);

        });
    });
}
