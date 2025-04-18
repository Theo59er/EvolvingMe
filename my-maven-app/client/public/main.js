const { app, BrowserWindow } = require('electron');
const { exec } = require('child_process');
const path = require('path');

let phpServer;

app.on('ready', () => {
    const phpPath = 'php';
    const publicDir = __dirname;
    phpServer = exec(`${phpPath} -S localhost:8000 -t "${publicDir}"`);

    // Erhöhe Timeout auf 2 Sekunden für langsamere Systeme
    setTimeout(() => {
        const win = new BrowserWindow({
            width: 800,
            height: 600,
            webPreferences: {
                nodeIntegration: true,
                contextIsolation: false
            }
        });

        win.loadURL('http://localhost:8000');
        win.webContents.openDevTools();

        win.on('closed', () => {
            if (phpServer) phpServer.kill();
        });
    }, 2000);
});

app.on('window-all-closed', () => {
    if (phpServer) phpServer.kill();
    app.quit();
});