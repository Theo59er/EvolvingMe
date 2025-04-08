const { app, BrowserWindow } = require('electron');
const { exec } = require('child_process');
const path = require('path');

let phpServer;

app.on('ready', () => {
    // Starten des PHP-Servers
    const phpPath = 'php'; // Stellen Sie sicher, dass PHP in Ihrem PATH ist
    const phpFile = path.join(__dirname, 'index.php');
    phpServer = exec(`${phpPath} -S localhost:8000 -t ${path.dirname(phpFile)}`);

    phpServer.stdout.on('data', (data) => {
        console.log(`PHP Server: ${data}`);
    });

    phpServer.stderr.on('data', (data) => {
        console.error(`PHP Server Error: ${data}`);
    });

    // Erstellen des Electron-Fensters
    const win = new BrowserWindow({
        width: 800,
        height: 600,
        webPreferences: {
            nodeIntegration: true
        }
    });

    // Laden der PHP-Seite über den lokalen Server
    win.loadURL('http://localhost:8000');

    win.on('closed', () => {
        // Beenden des PHP-Servers, wenn das Fenster geschlossen wird
        if (phpServer) phpServer.kill();
    });
});

app.on('window-all-closed', () => {
    if (phpServer) phpServer.kill();
    app.quit();
});