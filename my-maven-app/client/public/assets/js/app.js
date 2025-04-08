document.getElementById('dataForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const weight = document.getElementById('weight').value;
    const mood = document.getElementById('mood').value;

    const data = { name, weight, mood, timestamp: new Date().toISOString() };

    if (isWindows()) {
        const filePath = await saveToWindowsRoaming(data);
        alert(`Data saved to: ${filePath}`);
    } else {
        alert('This feature is only supported on Windows.');
    }
});

document.getElementById('searchButton').addEventListener('click', async function () {
    const searchName = document.getElementById('searchName').value;

    if (isWindows()) {
        const result = await searchInWindowsRoaming(searchName);
        document.getElementById('searchResult').innerText = result
            ? JSON.stringify(result, null, 2)
            : 'No data found for the given name.';
    } else {
        alert('This feature is only supported on Windows.');
    }
});

function isWindows() {
    return navigator.platform.indexOf('Win') > -1;
}

async function saveToWindowsRoaming(data) {
    const { app } = require('electron').remote;
    const fs = require('fs');
    const path = require('path');

    const roamingPath = path.join(app.getPath('appData'), 'EvolvingME');
    if (!fs.existsSync(roamingPath)) {
        fs.mkdirSync(roamingPath);
    }

    const filePath = path.join(roamingPath, 'data.json');
    let existingData = [];

    if (fs.existsSync(filePath)) {
        existingData = JSON.parse(fs.readFileSync(filePath, 'utf-8'));
    }

    existingData.push(data);
    fs.writeFileSync(filePath, JSON.stringify(existingData, null, 2));

    return filePath;
}

async function searchInWindowsRoaming(name) {
    const { app } = require('electron').remote;
    const fs = require('fs');
    const path = require('path');

    const filePath = path.join(app.getPath('appData'), 'EvolvingME', 'data.json');
    if (!fs.existsSync(filePath)) {
        return null;
    }

    const existingData = JSON.parse(fs.readFileSync(filePath, 'utf-8'));
    return existingData.find(entry => entry.name === name);
}