const fs = require('fs');
const path = require('path');

document.getElementById('dataForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const weight = document.getElementById('weight').value;
    const mood = document.getElementById('mood').value;

    const data = { name, weight, mood, timestamp: new Date().toISOString() };

    saveDataLocally(data);
    alert('Data saved successfully!');
});

document.getElementById('searchButton').addEventListener('click', function () {
    const searchName = document.getElementById('searchName').value;
    const result = searchDataLocally(searchName);

    document.getElementById('searchResult').innerText = result
        ? JSON.stringify(result, null, 2)
        : 'No data found for the given name.';
});

function saveDataLocally(data) {
    const filePath = path.join(__dirname, 'data', 'data.json');

    // Erstelle den Ordner, falls er nicht existiert
    if (!fs.existsSync(path.dirname(filePath))) {
        fs.mkdirSync(path.dirname(filePath), { recursive: true });
    }

    let existingData = [];

    // Lese bestehende Daten, falls die Datei existiert
    if (fs.existsSync(filePath)) {
        existingData = JSON.parse(fs.readFileSync(filePath, 'utf-8'));
    }

    // Füge die neuen Daten hinzu
    existingData.push(data);

    // Schreibe die Daten zurück in die Datei
    fs.writeFileSync(filePath, JSON.stringify(existingData, null, 2));
}

function searchDataLocally(name) {
    const filePath = path.join(__dirname, 'data', 'data.json');

    if (!fs.existsSync(filePath)) {
        return null;
    }

    const existingData = JSON.parse(fs.readFileSync(filePath, 'utf-8'));
    return existingData.find(entry => entry.name === name);
}