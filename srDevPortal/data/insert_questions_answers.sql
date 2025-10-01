USE iste498t02;

INSERT INTO questions (question, question_type, input_type, name)
  VALUES ('What is your preferred name?', 'informational', 'text', 'preferredName'),
  ('What is your RIT username?', 'informational', 'text', 'id'),
  ('What is your major?', 'informational', 'select', 'major'),
  ('What ISTE500 section are you in?', 'informational', 'select', 'section');

INSERT INTO questions (question, question_type, input_type)
  VALUES ('I work well under pressure.', 'personality', 'range'),
  ('I am a good problem solver.', 'personality', 'range'),
  ('I like taking notes.', 'personality', 'range'),
  ('I have good writing skills.', 'personality', 'range'),
  ('I have good time management skills.', 'personality', 'range'),
  ('I usually communicate well with group members.', 'personality', 'range'),
  ('I am usually more assertive than I am passive.', 'personality', 'range'),
  ('I am usually more cautious than I am impulsive.', 'personality', 'range'),
  ('I am usually more patient than I am impatient.', 'personality', 'range'),
  ('I am usually more outgoing than I am shy.', 'personality', 'range'),
  ('I am usually more laid back than I am uptight.', 'personality', 'range'),
  ('I think I would do well with understanding/determining client needs.', 'personality', 'range'),
  ('Taking the lead on projects appeals to or comes easily to me.', 'personality', 'range'),
  ('Presenting in front of others appeals to or comes easily to me.', 'personality', 'range'),
  ('Interviewing people I may not know appeals to or comes easily to me.', 'personality', 'range'),
  ('I work on one task at a time, as opposed to jumping around on tasks.', 'personality', 'range'),
  ('If I do not know something, I would rather figure it out myself than ask for help.', 'personality', 'range'),
  ('If there is a problem, I explore multiple solutions rather than choosing the first one I find.', 'personality', 'range');
  
INSERT INTO questions (question, question_type, input_type)
  VALUES ('How confident are you in your HTML skills?', 'technical', 'range'),
  ('How confident are you in your CSS skills?', 'technical', 'range'),
  ('How confident are you in your JavaScript skills?', 'technical', 'range'),
  ('How confident are you in your php skills?', 'technical', 'range'),
  ('How confident are you in your Python skills?', 'technical', 'range'),
  ('How confident are you in your C skills?', 'technical', 'range'),
  ('How confident are you in your C# skills?', 'technical', 'range'),
  ('How confident are you in your C++ skills?', 'technical', 'range'),
  ('How confident are you in your Java skills?', 'technical', 'range'),
  ('How confident are you in your ability to develop a front-end?', 'technical', 'range'),
  ('How confident are you in your ability to design a front-end?', 'technical', 'range'),
  ('How confident are you in your ability to develop a back-end?', 'technical', 'range'),
  ('How confident are you in your ability to design a system architecture?', 'technical', 'range'),
  ('How confident are you in your MySQL skills?', 'technical', 'range'),
  ('How confident are you in your database development skills?', 'technical', 'range'),
  ('How confident are you in your database management skills?', 'technical', 'range'),
  ('How confident are you in your ability to write code that interacts with databases?', 'technical', 'range'),
  ('How confident are you using the command line?', 'technical', 'range'),
  ('How confident are you in your wireframing and prototyping skills?', 'technical', 'range'),
  ('How confident are you in your ability to conduct usability testing?', 'technical', 'range'),
  ('How confident are you in planning and conducting user interviews?', 'technical', 'range'),
  ('How confident are you in your ability to create effective and visually appealing UI designs?', 'technical', 'range'),
  ('How confident are you in your graphic design skills?', 'technical', 'range'),
  ('How confident are you in your mobile development skills?', 'technical', 'range'),
  ('How confident are you in your Swift skills?', 'technical', 'range'),
  ('How confident are you in your Kotlin skills?', 'technical', 'range'),
  ('How confident are you in your ability to develop a cross-platform mobile application?', 'technical', 'range'),
  ('How confident are you in your ability to develop a web app?', 'technical', 'range'),
  ('How confident are you in your networking skills?', 'technical', 'range');

INSERT INTO answers (question_id, answer)
  VALUES (2, 'WMC'),
  (2, 'HCC'),
  (2, 'CIT'),
  (3, '01'),
  (3, '02');