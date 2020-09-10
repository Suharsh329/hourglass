DROP TABLE IF EXISTS boards;
DROP TABLE IF EXISTS tasks_notes;

CREATE TABLE IF NOT EXISTS boards(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE
);

INSERT OR IGNORE INTO boards VALUES(1, 'Main');

CREATE TABLE IF NOT EXISTS tasks_notes(
    tnid INTEGER PRIMARY KEY AUTOINCREMENT,
    id INTEGER NOT NULL,
    description TEXT NOT NULL,
    date TEXT NOT NULL,
    due_date TEXT DEFAULT "Indefinite",
    completed INTEGER DEFAULT 0,
    type TEXT NOT NULL,
	recurring INTEGER DEFAULT 0,
	repeat INTEGER DEFAULT 0,
    board TEXT,
    FOREIGN KEY(board) REFERENCES boards(name)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS archives(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    description TEXT NOT NULL,
    date TEXT NOT NULL,
    type TEXT NOT NULL,
    board TEXT
);
