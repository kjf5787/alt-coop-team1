USE iste498t02;

CREATE TABLE students (
	id VARCHAR(30) PRIMARY KEY,
  email VARCHAR(50) NOT NULL,
  preferredName VARCHAR(50) NOT NULL,
  major VARCHAR(10),
  section VARCHAR(10)
);

CREATE TABLE questions (
	id INT AUTO_INCREMENT PRIMARY KEY,
  question TEXT NOT NULL,
  question_type VARCHAR(255) NOT NULL,
  input_type VARCHAR(255) NOT NULL,
  name VARCHAR(50)
);

CREATE TABLE student_answers (
	id INT AUTO_INCREMENT PRIMARY KEY,
	student_id VARCHAR(30) NOT NULL,
  question_id INT NOT NULL,
  answer VARCHAR(255) NOT NULL,
  CONSTRAINT fk_student_answers_students 
    FOREIGN KEY (student_id) 
    REFERENCES students(id),
  CONSTRAINT fk_student_answers_questions
    FOREIGN KEY (question_id) 
    REFERENCES questions(id)
);

CREATE TABLE answers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question_id INT NOT NULL,
  answer TEXT NOT NULL,
  CONSTRAINT fk_answers_questions 
    FOREIGN KEY (question_id)
    REFERENCES questions(id)
);