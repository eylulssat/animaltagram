// Firebase modüllerini içe aktar
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-auth.js";
import { getFirestore } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-firestore.js";
import { getStorage } from "https://www.gstatic.com/firebasejs/11.6.0/firebase-storage.js";

// Firebase konfigürasyon
const firebaseConfig = {
    apiKey: "AIzaSyDn-6caC0Rcyi9mT3UpkcR_ssJNetv9JDM",
    authDomain: "yetenektakasi-1754f.firebaseapp.com",
    projectId: "yetenektakasi-1754f",
    storageBucket: "yetenektakasi-1754f.firebasestorage.app",
    messagingSenderId: "461497949261",
    appId: "1:461497949261:web:321fe85650a6e5e765d004"
};

// Firebase başlatma
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
getFirestore(app); 
getStorage(app);  

// Kayıt olma (register)
document.getElementById("submit").addEventListener("click", function (event) {
    event.preventDefault();

    const email = document.getElementById("registerEmail").value;
    const password = document.getElementById("registerPassword").value;

    createUserWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            const user = userCredential.user;
            alert("Hesap başarıyla oluşturuldu!");

            // Kullanıcı ID'sini localStorage'a kaydet
            localStorage.setItem("userId", user.uid);

            // İsteğe bağlı: kullanıcı profil sayfasına yönlendir
            window.location.href = "profil.html";
        })
        .catch((error) => {
            alert("Hata: " + error.message);
        });
});

// Giriş yapma (login)
document.getElementById("login").addEventListener("click", function (event) {
    event.preventDefault();

    const email = document.getElementById("loginEmail").value.trim();
    const password = document.getElementById("loginPassword").value;

    if (!email || !password) {
        alert("Lütfen e-posta ve şifre girin.");
        return;
    }

    signInWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            const user = userCredential.user;
            const email = user.email;

            // userId'yi localStorage'a kaydet
            localStorage.setItem("userId", user.uid);
            localStorage.setItem("userEmail", email);

            alert("Giriş başarılı! Hoş geldiniz, " + user.email);
            window.location.href = "profil.html"; 
        })
        .catch((error) => {
            if (error.code === "auth/user-not-found") {
                alert("Kullanıcı bulunamadı.");
            } else if (error.code === "auth/wrong-password") {
                alert("Hatalı şifre.");
            } else {
                alert("Giriş hatası: " + error.message);
            }
        });
});