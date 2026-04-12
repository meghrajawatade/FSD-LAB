const express = require('express');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;
const DB_PATH = path.join(__dirname, 'db', 'books.json');

app.use(express.json());

function readBooks() {
  const raw = fs.readFileSync(DB_PATH, 'utf8');
  return JSON.parse(raw || '[]');
}

function writeBooks(books) {
  fs.writeFileSync(DB_PATH, JSON.stringify(books, null, 2));
}

app.get('/books', (req, res) => {
  const books = readBooks();
  res.status(200).json(books);
});

app.post('/books', (req, res) => {
  const { title, author, year } = req.body;

  if (!title || !author) {
    return res.status(400).json({
      message: 'title and author are required'
    });
  }

  const books = readBooks();
  const newBook = {
    id: books.length ? books[books.length - 1].id + 1 : 1,
    title,
    author,
    year: year || null,
    createdAt: new Date().toISOString()
  };

  books.push(newBook);
  writeBooks(books);

  res.status(201).json({
    message: 'Book added successfully',
    data: newBook
  });
});

app.put('/books/:id', (req, res) => {
  const id = Number(req.params.id);
  const { title, author, year } = req.body;

  if (!title || !author) {
    return res.status(400).json({
      message: 'title and author are required'
    });
  }

  const books = readBooks();
  const index = books.findIndex((book) => book.id === id);

  if (index === -1) {
    return res.status(404).json({
      message: 'Book not found'
    });
  }

  books[index] = {
    ...books[index],
    title,
    author,
    year: year || null,
    updatedAt: new Date().toISOString()
  };

  writeBooks(books);

  res.status(200).json({
    message: 'Book updated successfully',
    data: books[index]
  });
});

app.get('/', (req, res) => {
  res.json({
    message: 'Simple Book REST API is running',
    endpoints: {
      listBooks: 'GET /books',
      addBook: 'POST /books',
      updateBook: 'PUT /books/:id'
    }
  });
});

app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
