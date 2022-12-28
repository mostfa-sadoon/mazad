// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
const firebaseConfig = {
    apiKey: "AIzaSyA14fIRJiJTGACLYvDgHl4Gf4YJaF7Cg9w",
    authDomain: "maza-74bb3.firebaseapp.com",
    projectId: "maza-74bb3",
    storageBucket: "maza-74bb3.appspot.com",
    messagingSenderId: "373443321646",
    appId: "1:373443321646:web:32b28629bab00bdc15e4bf",
    measurementId: "G-46CG11HDL6"
  };

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});