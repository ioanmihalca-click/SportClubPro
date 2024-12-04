import './bootstrap';


//PWA

let deferredPrompt;
const installButton = document.getElementById('installApp');

window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent Chrome 67 and earlier from automatically showing the prompt
    e.preventDefault();
    // Stash the event so it can be triggered later.
    deferredPrompt = e;
    // Show the install button
    installButton.style.display = 'inline-flex';
});

installButton.addEventListener('click', async () => {
    if (deferredPrompt) {
        // Show the install prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        const { outcome } = await deferredPrompt.userChoice;
        // We've used the prompt, and can't use it again, throw it away
        deferredPrompt = null;
        // Hide the install button
        installButton.style.display = 'none';
    }
});

// Hide the install button if the app is already installed
window.addEventListener('appinstalled', () => {
    installButton.style.display = 'none';
});

