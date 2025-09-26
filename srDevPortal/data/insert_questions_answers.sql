USE iste498t02;

INSERT INTO questions (id, question, question_type, input_type)
  VALUES (0, 'What is your preferred name?', 'informational', 'short answer'),
  (1, 'What is your email?', 'informational', 'short answer'),
  (2, 'What is your major?', 'informational', 'multiple choice'),
  (3, 'What ISTE500 section are you in?', 'informational', 'multiple choice');

INSERT INTO questions (question, question_type, input_type)
  VALUES ('I work well under pressure.', 'personality', 'scale'),
  ('I am a good problem solver.', 'personality', 'scale'),
  ('I like taking notes.', 'personality', 'scale'),
  ('I have good writing skills.', 'personality', 'scale'),
  ('I have good time management skills.', 'personality', 'scale'),
  ('I usually communicate well with group members.', 'personality', 'scale'),
  ('I am usually more assertive than I am passive.', 'personality', 'scale'),
  ('I am usually more cautious than I am impulsive.', 'personality', 'scale'),
  ('I am usually more patient than I am impatient.', 'personality', 'scale'),
  ('I am usually more outgoing than I am shy.', 'personality', 'scale'),
  ('I am usually more laid back than I am uptight.', 'personality', 'scale'),
  ('I think I would do well with understanding/determining client needs.', 'personality', 'scale'),
  ('Taking the lead on projects appeals to or comes easily to me.', 'personality', 'scale'),
  ('Presenting in front of others appeals to or comes easily to me.', 'personality', 'scale'),
  ('Interviewing people I may not know appeals to or comes easily to me.', 'personality', 'scale'),
  ('I work on one task at a time, as opposed to jumping around on tasks.', 'personality', 'scale'),
  ('If I do not know something, I would rather figure it out myself than ask for help.', 'personality', 'scale'),
  ('If there is a problem, I explore multiple solutions rather than choosing the first one I find.', 'personality', 'scale');
  
INSERT INTO questions (question, question_type, input_type)
  VALUES ('How confident are you in your HTML skills?', 'technical', 'scale'),
  ('How confident are you in your CSS skills?', 'technical', 'scale'),
  ('How confident are you in your JavaScript skills?', 'technical', 'scale'),
  ('How confident are you in your php skills?', 'technical', 'scale'),
  ('How confident are you in your Python skills?', 'technical', 'scale'),
  ('How confident are you in your C skills?', 'technical', 'scale'),
  ('How confident are you in your C# skills?', 'technical', 'scale'),
  ('How confident are you in your C++ skills?', 'technical', 'scale'),
  ('How confident are you in your Java skills?', 'technical', 'scale'),
  ('How confident are you in your ability to develop a front-end?', 'technical', 'scale'),
  ('How confident are you in your ability to design a front-end?', 'technical', 'scale'),
  ('How confident are you in your ability to develop a back-end?', 'technical', 'scale'),
  ('How confident are you in your ability to design a system architecture?', 'technical', 'scale'),
  ('How confident are you in your MySQL skills?', 'technical', 'scale'),
  ('How confident are you in your database development skills?', 'technical', 'scale'),
  ('How confident are you in your database management skills?', 'technical', 'scale'),
  ('How confident are you in your ability to write code that interacts with databases?', 'technical', 'scale'),
  ('How confident are you using the command line?', 'technical', 'scale'),
  ('How confident are you in your wireframing and prototyping skills?', 'technical', 'scale'),
  ('How confident are you in your ability to conduct usability testing?', 'technical', 'scale'),
  ('How confident are you in planning and conducting user interviews?', 'technical', 'scale'),
  ('How confident are you in your ability to create effective and visually appealing UI designs?', 'technical', 'scale'),
  ('How confident are you in your graphic design skills?', 'technical', 'scale'),
  ('How confident are you in your mobile development skills?', 'technical', 'scale'),
  ('How confident are you in your Swift skills?', 'technical', 'scale'),
  ('How confident are you in your Kotlin skills?', 'technical', 'scale'),
  ('How confident are you in your ability to develop a cross-platform mobile application?', 'technical', 'scale'),
  ('How confident are you in your ability to develop a web app?', 'technical', 'scale'),
  ('How confident are you in your networking skills?', 'technical', 'scale');

INSERT INTO answers (question_id, answer)
  VALUES (2, 'WMC'),
  (2, 'HCC'),
  (2, 'CIT'),
  (3, '01'),
  (3, '02');