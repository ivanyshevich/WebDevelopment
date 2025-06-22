// lab13/app.js
const http = require('http');
const fs = require('fs');
const moment = require('moment');

const PORT = 3000;

const server = http.createServer((req, res) => {
  // Головний маршрут
  if (req.url === '/') {
    res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
    return res.end('Вітаю! Це мій перший Node.js сервер.\n');
  }

  // Маршрут для читання файлу data.txt
  if (req.url === '/file') {
    return fs.readFile('data.txt', 'utf8', (err, data) => {
      if (err) {
        res.writeHead(500, { 'Content-Type': 'text/plain; charset=utf-8' });
        return res.end('Помилка при читанні файлу.');
      }
      res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
      res.end(data);
    });
  }

  // Маршрут для виводу поточного часу
  if (req.url === '/time') {
    const now = moment().format('YYYY-MM-DD HH:mm:ss');
    res.writeHead(200, { 'Content-Type': 'text/plain; charset=utf-8' });
    return res.end(`Поточна дата й час: ${now}\n`);
  }

  // Маршрут, що повертає JSON
  if (req.url === '/json') {
    const payload = {
      status: 'ok',
      timestamp: Date.now()
    };
    res.writeHead(200, { 'Content-Type': 'application/json; charset=utf-8' });
    return res.end(JSON.stringify(payload));
  }

  // Якщо маршрут не знайдено
  res.writeHead(404, { 'Content-Type': 'text/plain; charset=utf-8' });
  res.end('404 Not Found');
});

server.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}/`);
});